
str1 = input()
str2 = input()

str1 = str1.lower()
str2 = str2.lower()

str1=str1.replace(" ", "")
str2=str2.replace(" ", "")

str1n = sorted(str1)
str2n = sorted(str2)

if str1n == str2n:
    print("True")
else:
    print("False")
