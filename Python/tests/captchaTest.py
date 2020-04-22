from request import captcha

captcha = captcha.CaptchaRequest(hostUrl="http://jwgl.thxy.cn",captchaUrl="http://jwgl.thxy.cn/yzm")
data = captcha.getRequest()
flag = captcha.downloadCaptcha(data)

if flag == True:
    print("OK")
else:
    print("FUCK")