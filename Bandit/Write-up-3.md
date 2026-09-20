Bandit level 11->12
Firstly i have displayed the file contets of data.txt using cat command and copied the 
file contents and from the given information in bandit websit the password is rotated by 13 
charqacters, so i have tried decoding it by rot13 command, since the function rot13 is not
available in users system i have tried with command tr by using the tr command i was able to find it the 
command i have used it was echo "Gur cnffjbeq vf TEBbmJCB8DlA0zTewHxVQ0JPLxMvDkeA" | tr 'A-Za-z' 'N-ZA-Mn-za-m'
The password is GROozWPO8QyN0mGrjUkID0WCYkZiQxrN

Bandit level 12->13
Firstly i have created a temporary directory and a file temp.txt to work on in /temp  
then i have copied the contents in data.txt to a temporary file in /temp directory which i have created
then first thing i have did is to convert the hexa dump file to normal using command xxd -r temp.txt > data
and i found the file type of the file data then i found out it is a gzip file then i have converted it 
into .gz file and then i have decompressed it using command gzip -d file.gz
upon repeted decompression using gzip -d , bzip2 -d and tar xf i have found the password
The password is qQYQiHOBPR8zR61qxYqX45quvihF2uzk
