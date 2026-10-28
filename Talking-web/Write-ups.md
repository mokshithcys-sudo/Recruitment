## Your First HTTP Request
In this level wee need to start a server in the GUI desktop.\
For starting that we need to use the command /challenge/server\
And we will get a url and we need to copy and past it in a browser in the GUI\
And i got my flag
### The flag is pwn.college{MsZ98CIx_WQDuu8daGdjTnlTP0K.0lMxgDNxwCMwQjN0IzW}

## Reading Flask
In this level we need to get a path so that we can find the flag.\
After starting the server using /challenge/server i used the same command in the same web browser \
The i got the next path as **"\submit"** i have added it to the stranded path and i got my flag.
### The flag is pwn.college{MjMmzhe91JNPaKbdr2dEMKASH2t.01MxgDNxwCMwQjN0IzW}

## Commented Data
In this level we need to use the same method as in the previous levels but,\
But here the flag is hidden in a comment in the source code \
Here i used the developer options and got the flag
### The flag is pwn.college{wTGzsFRwGHuPhhNxoPO26peO47T.0FNxgDNxwCMwQjN0IzW}

## HTTP Meta Data
In this level we need to find the flag hidden in the headers location\
For that wee need to go to the network options in the developer tools and i got the flag.
### The flag is pwn.college{41fHbGtywTz03PpbxUbZZWbXbKu.0VNxgDNxwCMwQjN0IzW}

## HTTP Netcat
In this we need to send a GET request to the local host and get our flag\
For that we can use nc or netcat command to make connection to the local host and can send a request\
First i used the **ip a** command to get the ip address of the localhost and then i used nc command to 
Send a GET request that is **nc -v 127.0.0.1 80** Then i sent the request\
```
GET / HTTP/1.1
Host: http://challenge.localhost/
```
And i got my flag
### The flag is pwn.college{cEDM2GSScY_p1680NwveVT0YT3Z.QX5YjMzwCMwQjN0IzW}

## HTTP Paths (netcat)
In this level we need to use the same method as the before level but we need\
To send the request to a different path which we can get in the /challenge/server in the browser\
The modified get request is 
```
GET /task HTTP/1.1
Host: challenge.localhost
```
And i got my flag
### The flag is pwn.college{4MocK_lalP8J0mD5qaXEy0urJwi.QX1cjMzwCMwQjN0IzW}

## HTTP Curl
In this level we need to send a get request using curl which is default attribute of curl command\
But before that we need to get the specified path to send the get request, we can get that path \
By checking the source code of /challenge/server and i got my path **/mission** and then 
I used the command **curl http://challenge.localhost/mission** to get the flag
### The flag is pwn.college{gMfVIE8DgrRBoK_zeOqFsrYSbjq.QX0cjMzwCMwQjN0IzW}

## HTTP Python
In this level we need to send the same get request but using python\
Here i used requests library to send the get request and .text to print the text which we get\
First i wrote some code in a python 
The code is :
```
import requests

url = "http://challenge.localhost/qualify

response = requests.get(url)

print(response.text)
```
Here .get will send the get request and .text will give all the\
Text lines present the response received by that get request.
### The flag is pwn.college{YF_OOWLWiNbOiUAqgiWj4PaJ1XM.QX2cjMzwCMwQjN0IzW}

## HTTP Host header Python
In this level we need to change a header using python and we need to send it as a get request\
First we need to find the path from the source code of /challenge/server not only that \
But also we will also get the information about the changes we need to do in the header\
That is **app.config["SERVER_NAME"] = "net-force.nl:80"** which means i need to change the host to\
**net-force.nl** and we need to do that using python the code i used here is :
```
import requests

response = requests.get(
    "http://challenge.localhost/mission",
    headers={"Host": "net-force.nl:80"}
)

print(response.text)
```
Here **requests.get** command will overwrite the host header and \
After running the python file i got the flag
### The flag is pwn.college{o7HmCzP8f_eu6xydj85BA7c3xq8.QXzcjMzwCMwQjN0IzW}

## HTTP Host Header curl
In this level we need to do the same thing as of the above level but\
We need to use the curl command for to give the get request\
The command i gave is **curl --header "Host:sadservers.com:80" http://challenge.localhost/entry** 
### The flag is pwn.college{g0rsGIAkDxOyMiU6CJcTpbf-he4.QXxcjMzwCMwQjN0IzW}

## HTTP Host Header Netcat
In this level we need to do the same thing as in the above level but \
Using Netcat nc command first i checked the source code for the path and the header i need to change\
Then i found the path as **/check** and **host = flaws.cloud** and i used the nc command to connect\
And given the request as and got the flag
```
GET /check HTTP/1.1
Host: flaws.cloud
```
### The flag is pwn.college{suCEXIdCTu283YZMi9Q1vtJ_P7s.QXycjMzwCMwQjN0IzW}

## URL Encoading
In this level we are given a path with spaces in between the words we need to make the path url\
And get the flag we can use nc command to send a get request and we can use %20 in the place of a blank or space\
Since %20 is the hexa decimal value of a space and first i checked the source code and fond the path which\
Contains a space and copied it and i have used **nc challenge.localhost 80** to start the connection\
And given the get request that is and i got the flag
```
GET /submission%20verify%20meet HTTP/1.1
Host: challenge.localhost
```
### The flag is pwn.college{EnY_3fy0yZJ_XCmt7EG_mhqtOSR.QX5cjMzwCMwQjN0IzW}

## HTTP GET Parameters
In this level we need to add a parameter in the get request \
First i checked the source code and got the file path /gate and \
We need to add a parameter using ? char and using nc \
First i used **nc challenge.localhost 80** and i added the get request:
```
GET /gate?unlock=pwgklefy
Host: challenge.localhost

```
### The flag is pwn.college{4xhwjjBvXhxYBG4BZrRHkUmFmTf.QXwgjMzwCMwQjN0IzW}

## Multiple HTTP parameters Netcat
In this level we need to use the same method as before level but we need to use 3 parameters\
Here we need to use & char to add more than 1 parameter, The code i used here is 
```
GET /progress?access_code=sfjezaue&security_token=kzvmodkx&token=afiepgey HTTP/1.1
Host: challenge.localhost
Connection: close
```
### The flag is pwn.college{cIZzlfD78X1Qu_8fvb-KpRc57wa.QX0gjMzwCMwQjN0IzW}

## Multiple HTTP parameters Curl
In this level we need to use the method but by using curl command 
The command i used is 
```
curl 'http://challenge.localhost/hack?pass=fjawumxb&security_token=yaanpzkj&security=xufooqmp'
```
Here we use the same method as in the above level by using ? and &\
And by using this command i got my flag.
### The flag is pwn.college{cxBQhGN9tibtaDrek_wK3rZbKVq.QXzgjMzwCMwQjN0IzW}
