#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>
#include <WiFiUdp.h>
#include <NTPClient.h>
#include <TimeLib.h>
#include <TM1637Display.h>

// Credenciais da rede Wi-Fi
const char* ssid = "SEU_SSID";
const char* password = "SUA_SENHA";

// Configurações do TM1637
#define CLK 2  // Pino de clock
#define DIO 4  // Pino de dados

TM1637Display display(CLK, DIO);  // Instância do display

// Configurações do sensor DHT
#define DHTPIN 14  // Pino digital do DHT11
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);

// Configurações do NTP
WiFiUDP ntpUDP;
NTPClient ntp(ntpUDP, "pool.ntp.br", -3 * 3600, 60000);  // UTC -3h, atualiza a cada 60s

// Configuração do servidor remoto
const char* remoteIPServer = "http://192.168.0.13/iot/dados.php";  // Altere para o IP/endpoint do servidor

void setup() {
  // Inicializar comunicação serial
  Serial.begin(115200);

  // Inicializar sensor DHT
  dht.begin();

  // Configurar o display TM1637
  display.setBrightness(0x0f);  // Brilho máximo

  // Conectar ao Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Conectando ao WiFi...");
  }
  Serial.println("Conectado ao WiFi!");
  Serial.print("Endereço IP: ");
  Serial.println(WiFi.localIP());

  // Iniciar cliente NTP
  ntp.begin();
  Serial.println("Cliente NTP iniciado.");
}

void loop() {
  // Atualizar hora NTP
  ntp.update();
  unsigned long epochTime = ntp.getEpochTime();
  setTime(epochTime);  // Define o tempo no formato TimeLib

  // Obter data e hora
  String dataAtual = String(day()) + "/" + String(month()) + "/" + String(year());
  String horaAtual = ntp.getFormattedTime();

  // Formatar o dia e o mês com dois dígitos (DDMM)
  int dia = day();
  int mes = month();
  char SDataDisplay[5];  // Vetor de char para armazenar a string "DDMM"

  // Formatar para garantir que dia e mês tenham dois dígitos
  sprintf(SDataDisplay, "%02d%02d", dia, mes);

  // Converte a string "DDMM" para número inteiro
  int DataDisplay = atoi(SDataDisplay);  // Converte "0705" para 705

  // Extrair apenas HHMM
  String SHoraDisplay = horaAtual.substring(0, 5);  // Pega os 5 primeiros caracteres: "HH:MM"

  // Remover o caractere ":" da string
  SHoraDisplay.replace(":", "");  // Agora ficará "HHMM"

  // Converte a string "HHMM" para número inteiro
  int HoraDisplay = atoi(SHoraDisplay.c_str());  // Converte "1234" para 1234

  // Obter dados do DHT11
  float temperatura = dht.readTemperature();
  float umidade = dht.readHumidity();

  // Validar leituras do DHT11
  if (isnan(temperatura) || isnan(umidade)) {
    Serial.println("Erro ao ler o sensor DHT!");
    temperatura = 0;
    umidade = 0;
  }

  // Exibir data, hora, temperatura e umidade no monitor serial
  Serial.println("=================================");
  Serial.print("Data: ");
  Serial.println(dataAtual);
  Serial.print("Hora: ");
  Serial.println(horaAtual);
  Serial.print("Temperatura: ");
  Serial.print(temperatura);
  Serial.println(" °C");
  Serial.print("Umidade: ");
  Serial.print(umidade);
  Serial.println(" %");

  // Exibir dados no display TM1637
  display.showNumberDec(DataDisplay, false, 4, 0);  // Dia e Mes
  delay(2000);                                      // Exibe por 2 segundos
  display.showNumberDec(HoraDisplay, false, 4, 0);  // Hora e Minuto
  delay(2000);
  display.showNumberDec(temperatura * 10, false, 4, 0);  // Temperatura
  delay(2000);                                           // Exibe por 2 segundos
  display.showNumberDec(umidade * 10, false, 4, 0);      // Umidade
  delay(500);

  // Montar JSON para envio
  String json = "{\"data\": \"" + dataAtual + "\", \"hora\": \"" + horaAtual + "\", \"temperatura\": " + String(temperatura, 1) + ", \"umidade\": " + String(umidade, 1) + "}";

  // Enviar JSON para o servidor remoto
  enviarParaServidor(json);

  // Aguardar 10 segundos antes de repetir
  delay(10000);
}

void enviarParaServidor(String json) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(remoteIPServer);                          // Define o endpoint do servidor
    http.addHeader("Content-Type", "application/json");  // Tipo de conteúdo

    // Envia uma requisição POST com o JSON
    int httpResponseCode = http.POST(json);

    // Verifica a resposta do servidor
    if (httpResponseCode > 0) {
      Serial.print("Resposta do servidor: ");
      Serial.println(httpResponseCode);
      Serial.print("Resposta: ");
      Serial.println(http.getString());  // Mostra a resposta no Serial Monitor
    } else {
      Serial.print("Erro ao enviar os dados: ");
      Serial.println(http.errorToString(httpResponseCode).c_str());
    }

    http.end();  // Finaliza a conexão HTTP
  } else {
    Serial.println("Conexão WiFi perdida!");
  }
}