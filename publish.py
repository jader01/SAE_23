import random
import paho.mqtt.client as mqtt
import datetime
import json, requests

##############################################################################################################################################
#
#                                                  Connexion à l'API
#
#############################################################################################################################################

lat = 43.433364 #on choisi la latitude
lon = 0.087047 #on choisi la longitude


headers = {'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:35.0) Gecko/20100101 Firefox/35.0','Cache-Control': 'no-cache, no-store, must-revalidate', 'Pragma': 'no-cache', 'Expires': '0'}#def de la requête http

url = requests.get(f"https://api.met.no/weatherapi/locationforecast/2.0/compact?lat={lat}&lon={lon}", headers=headers) #ici on as la requette avec le lien de l'api, et la latitude et la longitude en paramètre
text = url.text #on associe a une variable texte l'url en texte
        #print(text)
        # Get JSON data
data = json.loads(text) #on associe a la variable data la variable text en format json
        #print(data)

##################################################################################################################################################
#
#                                               import donné json dans le tableau
#
##################################################################################################################################################

        # Process JSON data
tab_val = [] #creation d'u tableau pour stock les valeur du json
units = data["properties"]["meta"]["units"] #on associe a la variable unit tout ce qui correspont aux valeur properties, meta et units dans le fichier data json
weather = data["properties"]["timeseries"][0]["data"]["instant"]["details"] #de même que précédemment mais cette fois ci avec de nouvelles valeur

for key in weather.keys(): #maintenant on fait une boucle qui parcours tous les élémentes dans weather
    date = datetime.datetime.now().strftime("%Y-%m-%d") # on associe a la variable date, la date actuelle sortie de la librairie date time
    heure = datetime.datetime.now().strftime("%H:%M:%S") #on associe a la variable heure, l'heure actuelle sortie de la librairie datetime
    tab_val.append("%s = %2.2f %s %s %s" %(key, weather[key], units[key], date, heure)) #on rajoute toutes ces valeur au tableau

##################################################################################################################################################
#
#                                               connexion au broker
#
##################################################################################################################################################

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
client.connect(broker, port) #connect au MQTT broket

for valeurs in tab_val:
    msg = valeurs
    result = client.publish(topic, msg)
    status = result[0]
    if status == 0:
        print(f"Send `{msg}` to topic `{topic}`")
    else:
        print(f"Failed to send message to topic {topic}") 
