ar = [1,2,3,4,5,6,7,8,9,10]
max1 = ar[0]
min1 = ar[0]

for i in ar:
    if i > max1:
        max1 = i

    if i<min1:
        min1 = i


max2 = ar[0]
min2 = ar[0]
for i in ar:
    if max1 > i > max2 :
        max2 = i

    if i>min1 :
        if i<min2 :
            min2 = i

print("second max ", max2)
print("second min ", min2)