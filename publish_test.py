import random
import paho.mqtt.client as mqtt
import datetime
import json, requests


lat = 43.433364 #on choisi la latitude
lon = 0.087047 #on choisi la longitude
headers = {'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:35.0) Gecko/20100101 Firefox/35.0','Cache-Control': 'no-cache, no-store, must-revalidate', 'Pragma': 'no-cache', 'Expires': '0'}
url = requests.get(f"https://api.met.no/weatherapi/locationforecast/2.0/compact?lat={lat}&lon={lon}", headers=headers)
text = url.text
        #print(text)
        # Get JSON data
data = json.loads(text)
        #print(data)

        # Process JSON data
tab_val = []
units = data["properties"]["meta"]["units"]
weather = data["properties"]["timeseries"][0]["data"]["instant"]["details"]
for key in weather.keys():
    date = datetime.datetime.now().strftime("%Y-%m-%d")
    heure = datetime.datetime.now().strftime("%H:%M:%S")
    tab_val.append("%s = %2.2f %s %s %s" %(key, weather[key], units[key], date, heure))



broker = 'test.mosquitto.org'
port = 1883
topic = "/RUEDASETZE"

client_id = f'python-mqtt-{random.randint(0, 1000)}' #on génère un id random

def on_connect(client, userdata, flags, rc, properties):
    if rc == 0:
        print("Connected to MQTT Broker!")
    if rc > 0:
        print("Failed to connect, return code %d\n", rc)

client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION1) #connection a la nouvelle version
client.on_connect = on_connect
client.connect(broker, port)

for valeurs in tab_val:
    msg = valeurs
    result = client.publish(topic, msg)
    status = result[0]
    if status == 0:
        print(f"Send `{msg}` to topic `{topic}`")
    else:
        print(f"Failed to send message to topic {topic}") 