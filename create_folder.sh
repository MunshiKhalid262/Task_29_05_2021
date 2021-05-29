FOLDER=$(cat /home/test-project/config/randomtext.txt)
mkdir -p /home/test-project/releases/$FOLDER
tar -C  /home/test-project/releases/$FOLDER -zxvf /home/test-project/config/$FOLDER.tar.gz
cd /home/test-project/releases/$FOLDER

