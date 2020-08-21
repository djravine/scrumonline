#!/bin/bash
command=$1
current_dir=$(pwd)
container_name=scrumonline
image=scrum-lamp

case $command in 
  "prepare")
     echo "Preparing repository for usage with docker"
     # run container with entrypoint which prepares container
     docker run --rm --name scrumonline -v $(pwd):/var/www/scrumonline --entrypoint /var/www/scrumonline/build.sh scrum-lamp
     ;;
  "build")
     echo "Building docker image"
     docker rmi scrum-lamp scrum-lamp-deploy
     cd docker
     docker build -t scrum-lamp -f Dockerfile .
     cd ..
     docker build -t scrum-lamp-deploy -f ./docker/Dockerfile-deploy .
     ;;
  "push")
     echo "Pushing docker image"
     aws ecr get-login-password --region ap-southeast-2 --profile developer | docker login --username AWS --password-stdin 636126172793.dkr.ecr.ap-southeast-2.amazonaws.com/ecr-dev-scrumonline
     docker tag scrum-lamp-deploy 636126172793.dkr.ecr.ap-southeast-2.amazonaws.com/ecr-dev-scrumonline:latest
     docker push 636126172793.dkr.ecr.ap-southeast-2.amazonaws.com/ecr-dev-scrumonline:latest
     ;;
  "secret")
     echo "Deploying secret to kubernetes"
     kubectl apply --wait -f ./docker/secret-scrumonline.yaml
     ;;
  "deploy")
     echo "Deploying to kubernetes"
     kubectl apply --wait -f ./docker/pod-scrumonline-mysql.yaml
     kubectl -n support rollout restart deployment scrumonline
     kubectl -n support rollout status deployment scrumonline
     ;;
  "start")
     running=$(docker ps -a -q | grep $container_name)
     if [ -n "$running" ]; then
        echo "Stopping running containers"
        docker stop $running
        docker rm $running
     fi
     
     echo "Starting container $container_name..."
     mysql_dir=$2
     if [ -n "$mysql_dir" ]; then     
        docker run -d --name $container_name -p 8080:80 -p 3306:3306 \
                    -v $current_dir:/var/www/scrumonline -v $current_dir/$mysql_dir:/var/lib/mysql \
                    $image
     else
        docker run -d --name $container_name -p 8080:80 -p 3306:3306 \
                    -v $current_dir:/var/www/scrumonline $image
     fi                
     echo "...done!"
     ;;
  "stop")
     echo "Stopping container $container_name..."
     docker stop $container_name
     docker rm $container_name
     echo "...done"
     ;;
  "readlog")
     log_name=$2
     if [ -n "$log_name" ]; then
       docker exec -it $container_name tail -f /var/log/apache2/$log_name.log
     else
       echo "No log name specified"
     fi
     ;;
  "db")
     docker exec -it $container_name mysql scrum_online -u root --password=passwd
     ;;
  "myadmin")
     mycommand=$2
     case $mycommand in
        "stop")
           docker stop myadmin
           docker rm myadmin
           ;;
        *)
           docker run --name myadmin -d --link $container_name:db -p 8081:80 phpmyadmin/phpmyadmin
           ;;
    esac
     ;;
  "bash")
     docker exec -it $container_name bash
     ;;
  "")
     echo "No command specified!"
     ;;   
esac
