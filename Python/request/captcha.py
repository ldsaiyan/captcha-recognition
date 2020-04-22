import requests

class CaptchaRequest:
    hostUrl = ""
    captchaUrl = ""
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36 QIHU 360SE'
    }
    session = None

    def __init__(self,hostUrl,captchaUrl):
        self.hostUrl = hostUrl
        self.captchaUrl = captchaUrl
        self.session = requests.session()
        self.session.get(url=self.hostUrl,headers=self.headers)


    def getRequest(self,payload={}):
        res = self.session.get(url=self.captchaUrl,headers=self.headers,params=payload)
        data = res.content
        return data

    def postRequest(self,data={}):
        res = self.session.post(url=self.captchaUrl, headers=self.headers,data=data)
        data = res.content
        return data

    def downloadCaptcha(self,data):
        with open('../source/captcha.gif','wb') as f:
            f.write(data)
        # judge
        return True
