## OSI Model and its layers
OSI or Open systems interconnection model is a conceptual model that \
Explains the process in which a data is transported through the network

### It has 7 layers

### 7. Aplication layer
```
Provides the user applications.
Examples: HTTP,HTTPS,DNS,FTP,SMTP
```

### 6. Presentation layer
```
It provides data formating, encryption and compression.
Examples: TLS/SSL(Secure Socket Layer),ASCII
```

### 5. Session layer
```
It handels/manages/terminates sessions
Examples: Session managment, RPC(Remote Procedure Call)
```

### 4. Transport layer
```
This layer provides end-to-end delivery of data and port addressing
That is from source application to destination application
Examples: TCP, UDP
```

### 3. Network layer
```
This layer handels logical addressing and routing.
This layer uses IP address for locating.
Examples: IP, ICMP (Internet Control Message Protocol)
```

### 2. Datalink layer
```
This layer transfers frames of data within a local network
Here local network can be LAN and Internet.
This layer uses MAC(Media Acess Control) address for transporting
Examples: Wi-Fi, Ethernet
```

### 1. Physical layer
```
This layer handels all the physical cables used for transmiting data
It can be optic cables, copper wires and radio signals.
```

## TCP/IP Model and its layers
TCP or Transmission Control Protocol model explain how the devices\
actually communicate over the internet in real.

### It has 4 layers

### 4. Application
```
Provides services for network applications.
Layers Application, Presentation, Session of
the OSI mode comes under this layer.
Examples: HTTP, HTTPS, DNS, FTP
```

### 3. Transport 
```
This layer provides End-to-end communication and data delivery.
Examples: TCP, UDP
```

### 2. Internet
```
This layer provides IP addressing and routing packets.
Examples: IPv4, IPv6, ICMP (Internet Control Message Protocol)
```

### 1. Network Access
```
This layer Sends data over the local network.
Examples: Ethernet, Wi-Fi
```

## IPv4 vs IPv6

### IPv4
IPv4 is the fourth version of the Internet Protocol. It assigns \
IP addresses to devices so that data packets can be routed \
from a source to a destination across networks.\
An IPv4 address uses 32 bits, divided into four \
groups of 8 bits called octets.

### IPv6
IPv6 is the newer version of the Internet Protocol, \
designed mainly to provide a much larger address space than IPv4.\
An IPv6 address uses 128 bits, written as hexadecimal and \
digits separated by colons.

### Key differences

| Feature | IPv4 | IPv6 |
|---|---|---|
| Address size | 32 bits | 128 bits |
| Address format | Decimal | Hexadecimal |
| Example | 192.168.1.10 | 2001:db8::10 |
| Address space | About 4.3 billion addresses | \(2^{128}\) addresses |
| Header | Variable, 20–60 bytes | Fixed, 40 bytes |
| Broadcast | Supported | Not supported |
| Security | IPsec support available | IPsec support defined in the standards |
| NAT | Commonly used | Generally less necessary |


## TCP Three-Way Handshake

The TCP Three-Way Handshake establishes a TCP connection \
between a client and a server before data transfer begins.\
After the connection is established we can start sending the data.

### The process:

### 1. Client -> Server
The client sends a SYN packet to request a connection.

### 2. Server -> Client
The server acknowledges the request and sends its own \
SYN whith a ACK packet

### 3. Client -> Server
The client acknowledges the server's response.
And the TCP connection is established.

The purpose for this three way handshake is to synchronize \
sequence numbers and establish a reliable TCP connection \
before data is transferred.
