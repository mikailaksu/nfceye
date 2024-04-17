from gtts import gTTS #okuma kütüphanesi
from modules.py532lib.i2c import * 
from modules.py532lib.frame import *
from modules.py532lib.constants import * #okuyucu kütüphaneleri
import requests
import urllib3
urllib3.disable_warnings()

pn532 = Pn532_i2c() #kartı tanımlama
pn532.SAMconfigure() #kartı ayarlama

#degiskenleri
sunucu = "http://localhost" //server adresi gir
cumle = ""
nid = ""
kyt = ""
kartcoz = 0
uid = ""
sonuc = ""
data = ""
headers = {
"Connection": "keep-alive",
"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.82 Safari/537.36",
"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
} #post değişkeni headeri

#calistiginde wifi'a baglansin diye beklettim
print("Baglanti icin 30 saniye bekleniyor...")
sleep(30)

#nfc id'den urun adını sorgulayan sayfa (post)
def sorgu(nid):
	url = sunucu + "proje/sorgula.php"
	data = {"nfc": nid}
	response = requests.post(url, headers=headers, data=data, verify=False,)
	adi = str(response.content,'utf-8')
	return adi

#kayıt bulamazsa kaydetsin diye actigim fonkyion
def kaydet(kyt):
	url = sunucu + "proje/add.php"
	data = {"nfc": kyt,"urunad":"Kaydedilmeyi Bekliyor.","kaydet":"",}
	response = requests.post(url, headers=headers, data=data, verify=False,)
	okut("Kayıt Bulunamadı. Kaydedilenler Listesine eklendi.")
	
#ürün adını sese text to speech kodu
def okut(cumle):
	tts = gTTS(text=str(cumle), lang='tr')
	tts.save("urun.mp3")
	os.system("mplayer urun.mp3")
	os.system("rm -rf urun.mp3")

#ekranda izlerken kart okutacagim zamanı söyleyen haberci :D
print('\nNFC Barkod Okutunuz...\n')

#kod sürekli çalışsın diye açtığım while true
while True:
	data=pn532.read_mifare().get_data() #burda kartın datasını şiflenmiş alıyor
	print (data) #şifrelenmiş datayı yazdırıyor
	print ("\nCozulmemis data uzunlugu: "+str(len(data))) #sifresini cozmeden once uzunlugunu merak edip yazdım
	for x in data: #dizideki degerleri alma
		sonuc = "%02X" % (x) #sifre çözen büyülü kod
		if kartcoz >= 7: #8. bitten sonra sifre cozuluyor 
			uid = uid + sonuc #cozulenleri topluyo
		kartcoz = kartcoz + 1 #donguyu bir arttır
	kartcoz = 0 #donguyu sıfırla
	print(str(len(uid))+"bit NFC etiket/kart bulundu UID: ",uid,"\n") #etiketin cozulmus idsini yazdir
	cevap = sorgu(uid) #sorgula ve cevabı yakala
	if cevap == "": #cevap kayıtsız ise kaydet
		print("Kaydediliyor...")
		kaydet(uid)
	else: #kayıtlı ise (2 ihtimal var zaten) oku ve ekrana yazdır
		print(cevap)
		okut(cevap)
	data = ""
	sonuc = ""
	uid = "" #degiskenleri kafayı yemesin diye sıfırladım
	print('\nNFC Barkod Okutunuz...\n')
	sleep(1)
