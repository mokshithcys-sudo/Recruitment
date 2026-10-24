## Your First HTTP Request
In this level wee need to start a server in the GUI desktop.\
For starting that we need to use the command /challenge/server\
And we will get a url and we need to copy and past it in a browser in the GUI\
And i got my flag that is **pwn.college{MsZ98CIx_WQDuu8daGdjTnlTP0K.0lMxgDNxwCMwQjN0IzW}**

## Reading Flask
In this level we need to get a path so that we can find the flag.\
After starting the server using /challenge/server i used the same command in the same web browser \
The i got the next path as **"\submit"** i have added it to the stranded path and i got my flag.\
The flag is **pwn.college{MjMmzhe91JNPaKbdr2dEMKASH2t.01MxgDNxwCMwQjN0IzW}**

## Commented Data
In this level we need to use the same method as in the previous levels but,\
But here the flag is hidden in a comment in the source code \
Here i used the developer options and got the flag\
The flag is **pwn.college{wTGzsFRwGHuPhhNxoPO26peO47T.0FNxgDNxwCMwQjN0IzW}**

## HTTP Meta Data
In this level we need to find the flag hidden in the headers location\
For that wee need to go to the network options in the developer tools and i got the flag.\
The flag is **pwn.college{41fHbGtywTz03PpbxUbZZWbXbKu.0VNxgDNxwCMwQjN0IzW}**

## HTTP Netcat
In this we need to send a GET request to the local host and get our flag\
For that we can use nc or netcat command to make connection to the local host and can send a request\
First i used the **ip a** command to get the ip address of the localhost and then i used nc command to 
Send a GET request that is **nc -v 127.0.0.1 80** Then i sent the request\
GET / HTTP/1.1 Host: http://challenge.localhost/ and i got my flag\
The flag is pwn.college{cEDM2GSScY_p1680NwveVT0YT3Z.QX5YjMzwCMwQjN0IzW}

## HTTP Paths (netcat)
In this level we need to use the same method as the before level but we need\
To send the request to a different path which we can get in the /challenge/server in the browser\
The modified get request is **GET /task HTTP/1.1 Host: challenge.localhost** and i got my flag\
The flag is pwn.college{4MocK_lalP8J0mD5qaXEy0urJwi.QX1cjMzwCMwQjN0IzW}

## HTTP Curl
In this level we need to send a get request using curl which is default attribute of curl command\
But before that we need to get the specified path to send the get request, we can get that path \
By checking the source code of /challenge/server and i got my path **/mission** and then 
I used the command curl http://challenge.localhost/mission to get the flag\
The flag is pwn.college{gMfVIE8DgrRBoK_zeOqFsrYSbjq.QX0cjMzwCMwQjN0IzW}

## HTTP Python
In this level we need to send the same get request but using python\
Here i used requests library to send the get request and .text to print the text which we get\
The code is :\
---
import requests
url = "http://challenge.localhost/qualify
response = requests.get(url)
print(response.text)

First i wrote some code in a python  
The flag is pwn.college{YF_OOWLWiNbOiUAqgiWj4PaJ1XM.QX2cjMzwCMwQjN0IzW}


   
