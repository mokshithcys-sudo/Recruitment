Bandit level 17-18
Firstly i have used ls -la command to find out all the files and directory then i found two files 
named passwords.new and passwords.old and it is said that one line in these two files does not 
match and it is the passwrod for the next level so i have used grep command to find the unique line
grep -F -x -v -f passwords.old passwords.new here -F means to give text line -x means to give the 
line which matches out of the two files and v for reversing as we want the line which does not match
after exicuting i got the password
The password is : OQxXZjELndr90zuhOTDYBEomI0SZITXI

Bandit level 18-19
After entering the password it just logged out back then i have saw that .bashrc was modified by the 
user and then i have tried to log in using different kind of way and they have mentioned that the 
password is in a readme file then the command used is ssh bandit18@bandit.labs.overthewire.org -p 2220 cat readme
Then i have got the password the password is : KpsOfPkcP7i1FlIExk2QEjyt6dw8dxZI

Bandit level 19-20
After connecting to the level i have used ls -la command to know what all files are there and that 
i found an odd file named bandit20-do then i have used file command to find out what kind to file it
is then i got that it is a setuid file and it is an executable file and i got to know that by exicuting
this file i can connect to the next level than i have used cat command to display the password to 
print the password for the next level and i have used the command ./bandit20-do cat /etc/bandit_pass/bandit20
The password is : 4pIjcunZ0fK2vmp3IwfG8Vf7VhxD6pOA

Bandit level 20-21
Firstly i have used ls -la command to find all the files present and found an odd one named suconnect and 
i found out that it is the same type of file of the last level that is setuid then i have used nmap to find
out open ports present and found out that there are two ports which 1234 and 4444 and 1234 worked in my 
case and tried to connect it and entered the password for the present level and got the password for next 
level The password is : bW9kBv5WC3P4yoDyf12LSdGuNz5ka6hY
