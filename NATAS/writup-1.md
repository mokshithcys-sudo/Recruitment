## Level 0 
In this level i typed the given url in my browser\
And logged in using the given credentials\
And after i inspected the web page using the inspect 
Method I found the password\
The password for natas1 is **scfWG6qNEIdzqVyfRwEGXyNUfFZkZeQ7**

## Level 0->1
In this level i used the given url and logged in using the username given\
And password got in the previous level.\
Here it told that right clicking is blocked so\
I used the command ctr + shift + I to unlock the developer option\
From there i went to the elements center and found the password.\
The password for natas2 is **vsDOxoXyq3wckCP1ZmTZ71ngIA606odB**

## Level 1->2
In this level also i have used the same method to find the flag.\
That is ctr + shift + I to unlock the developer option and check for it.\
There i saw a image file whose source is like files/pixel.org\
Which means there is a files folder where somthing can be stored\
But i dint find any other files in the files folder so i have changed the url a bit\
That is http://natas2.natas.labs.overthewire.org/files/ and i found a txtt file named users.txt.\
And found the password for natas3 **K30JrSRHzjxq3paUQuwozY4MNvmNFyhI**

## Level 2->3
After logging in i opened the developer tools and found a clue that\
<!-- No more information leaks!! Not even Google will find it this time... -->
Here this clue means Google uses crawlers, and websites commonly use robots.txt to give crawlers instructions.\
So after modifing the url a bit thaat is http://natas3.natas.labs.overthewire.org/robots.txt\
I got another clue that is User-agent: * Disallow: /s3cr3t/ which means\
there can be somthing in that folder\
and i have used url http://natas3.natas.labs.overthewire.org/robots.txt to get the password.\
The password for natas4 is **JDrPnuZAKyl6MkiqQGFIddrqpvgOASth**
