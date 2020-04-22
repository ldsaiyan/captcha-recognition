import tkinter
from PIL import Image, ImageTk

def train ():
    pass


def binarization ():
    im = Image.open('../source/captcha.gif')
    width,height = im.size
    imageList = [[0 for i in range(width)] for j in range(height)]

    for y in range(height):
        for x in range(width):
            pix = im.load()
            if (pix[x,y][0]<=150 and pix[x,y][1]<=150 and pix[x,y][2]<=150):
                imageList[y][x] = 1
            else:
                imageList[y][x] = 0

    return imageList,width,height

def show (imageList,width,height):
    codeStr = ''

    for y in range(height):
        for x in range(width):
            if x == width-1:
                codeStr += '\n'
            else:
                codeStr += str(imageList[y][x])

    return codeStr

imageList,width,height = binarization()
codeStr = show(imageList,width,height)


def split(imageList) :
    pass



def getInput ():
    str = trainInputEntry.get()
    train(str)

window = tkinter.Tk()
window.title("人工不智能训练机")
# window.geometry("270x130+200+200")

captcha = ImageTk.PhotoImage(Image.open('../source/captcha.gif'))
trainImgLabel = tkinter.Label(window,image=captcha)
trainInputEntry = tkinter.Entry(window,text='这里放输入框',width=20)
trainAddButton = tkinter.Button(window,text='Add',width=20,command=getInput)
trainShowCode = tkinter.Text(window,width=width,height=height)
trainShowCode.insert('insert',codeStr)

# codeFile = open('codeFile.txt','w+')
# codeFile.write(str(list))
# codeFile.close()

trainImgLabel.pack()
trainInputEntry.pack(pady=5)
trainAddButton.pack()
trainShowCode.pack()

window.mainloop()