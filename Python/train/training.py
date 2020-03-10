import tkinter
from PIL import Image, ImageTk

def getInput ():
    str = trainInputEntry.get()
    print(str)

window = tkinter.Tk()
window.title("人工不智能训练机")
window.geometry("270x130+200+200")

captcha = ImageTk.PhotoImage(Image.open('../source/captcha.gif'))
trainImgLabel = tkinter.Label(window,image=captcha)
trainInputEntry = tkinter.Entry(window,text='这里放输入框',width=20)
trainAddButton = tkinter.Button(window,text='Add',width=20,command=getInput)

trainImgLabel.pack()
trainInputEntry.pack(pady=5)
trainAddButton.pack()



window.mainloop()