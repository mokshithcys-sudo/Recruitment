n = int(input("enter how many numbers you want: "))
target = int(input("enter target: "))
nums= []
for i in range(0, n):
    nums.append(int(input("enter number: ")))


seen = set()
pairs = []

for num in nums:
    complement = num ^ target
    if complement in seen:
        pairs.append((complement, num))
    seen.add(num)

print(f"Pairs with XOR equal to {target}: {pairs}")