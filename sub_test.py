import random
import json
import paho.mqtt.client as mqtt
import sqlite3
import datetime
import time

conn = sqlite3.connect('database.sqlite')
cur = conn.cursor()


broker = 'test.mosquitto.org'
port = 1883
topic = "/RUEDASETZE"

# generate client ID with pub prefix randomly
client_id = f'python-mqtt-{random.randint(0, 100)}'

def connect_mqtt() -> mqtt:
    def on_connect(client, userdata, flags, rc):
        if rc == 0:
            print("Connected to MQTT Broker!")
        if rc > 0:
            print("Failed to connect, return code %d\n", rc)

    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION1, client_id)
    client.on_connect = on_connect
    client.connect(broker, port)
    return client
    

def subscribe(client: mqtt):
    def on_message(client, userdata, msg):
        tableau_avec_chaque_champ = []
        
        s = msg.payload.decode('utf-8')
        
        tableau_avec_chaque_champ = s.split(" ")
        
        print(tableau_avec_chaque_champ[0],
              tableau_avec_chaque_champ[2],
              tableau_avec_chaque_champ[3],
              tableau_avec_chaque_champ[4],
              tableau_avec_chaque_champ[5])

        cur.execute("INSERT INTO weather(name, value, units, date, hour) VALUES (?, ?, ?, ?, ?)",(tableau_avec_chaque_champ[0], tableau_avec_chaque_champ[2], tableau_avec_chaque_champ[3], tableau_avec_chaque_champ[4], tableau_avec_chaque_champ[5]))
        conn.commit()

                                        

    client.on_message = on_message
    client.subscribe(topic)



def run():
    client = connect_mqtt()
    subscribe(client)
    client.loop_forever()
    
    conn.close()


if __name__ == '__main__':
    run()
