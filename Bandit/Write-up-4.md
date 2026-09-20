Bandit level 13->14 
Firstly i have checked for any files in the home address there is a file named sshkey.private i have 
copied its contents to my local address and saved it intoprivate.key file. Then i have changed its 
permisson to 700 using the chmod command ie "chmod 700 private.key" then by using the ssh identity
command i have logged into the bandit 14th level the command is 
ssh bandit14@bandit.labs.overthewire.org -p 2220 -i private.key

Bandit level 14->15
firstly i found the password for bandit level 14 form /etc/bandit_pass/bandit14 location 
ie aaWecNkG4FhxJQxz07uiwzVP6bJiYS65 then i have used nc command to connect to localhost at port no 
30000. then after entering the password of bandit level 14 i got the password for bandit level 15
The password is pbLYuZtTg4MgaqfJx8jbA9gKKGqM68A7

Bandit level 15-16
Firstly i have used ls -la command to find out what all files are present here 
then after using the command openssl s_client for encrypting the password in the form ssl/tls
i have connected to localhost at port no 30001 the command is openssl s_client -connect localhost:30001
then after entering the password of the current level i got the password for the next level
The password is kS0Hf0u5HiXFwKMKFqXvPdOTNGGa0X8V

Bandit level 16-17
Firstly i have used ls -la command to find out what all files are present here
then according to the give details i have used nmap to scan ports from 3100 to 3200 and found out
that there are 5 open ports in those 5 ports only one port acts like a server ie port no 31790
after finding that i have used openssl s_client command to connect with the server and entered the
password of the current level but i didnt got the password or any private key for the next level
then i found out that since the password is starting with letter k the server is thinking it as an 
interactive command like e for exit q for quit so i have used -quite flag to think as an message and 
not as an interactive command and i got an private key which i have used to open the next level.
