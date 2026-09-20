s = input("Enter a string: ")

letters = []
for ch in s:
    if ch.isalpha():
        letters.append(ch)

result = ""
for ch in s:
    if ch.isalpha():
        result += letters.pop()
    else:
        result += ch

print("Result is :", result)
