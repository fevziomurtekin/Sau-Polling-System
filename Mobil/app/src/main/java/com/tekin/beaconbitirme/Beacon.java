package com.tekin.beaconbitirme;

import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.widget.Toast;

import com.estimote.sdk.BeaconManager;
import com.estimote.sdk.Region;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

/**
 * Created by Ömür on 31.12.2016.
 */
public class Beacon {
    Context context;
    private BeaconManager beaconManager;
    String firsbeacon_uuid;
    org.altbeacon.beacon.Beacon be;
    com.estimote.sdk.Beacon beacon;
    int enYakinIndis=0;
    int i=0;
    String uuid,ad,numara;
    ArrayList<String> dersAdi=new ArrayList<>();
    int major,minor;
    HashMap data = new HashMap();
    private final String serverUrl = "http://10.7.82.170:8088/yoklama.php";
    ArrayList<Double>distance=new ArrayList<>();
    ArrayList<com.estimote.sdk.Beacon> beacons=new ArrayList<>();
    int firstbeacon_major,first_beacon_minor;
    private List<com.estimote.sdk.Beacon> regionsToMonitor = new ArrayList<>();
    public Beacon(final Context context, final String ad, final String numara) throws InterruptedException {

        this.context = context;
        this.ad=ad;
        this.numara=numara;
        beaconManager = new BeaconManager(context);
        beaconManager.setRangingListener(new BeaconManager.RangingListener() {
            @Override
            public void onBeaconsDiscovered(Region region, List<com.estimote.sdk.Beacon> list) {

                if (list.size() > 0) {

                    //Tarama yapıldıysa ve beacon bulunduysa.
                    //Bulunan beaconların RSSI ve Power değerleri gönderilerek uzaklıkları bulunur ve bir distance listesine eklenir.

                    for (int x = 0; x < list.size(); x++) {

                        distance.add(getDistance(list.get(x).getRssi(),list.get(x).getMeasuredPower()));
                        beacons.add(list.get(x));
                    }

                    // Eğer bir tane beacon varsa enYakınIndisi o beaconın indisi olacaktır.

                    for(int y=0;y<list.size();y++)
                    {
                        if(list.size()==1){
                            if(distance.get(0)<0.1){
                                enYakinIndis=0;

                            }}
                        if(list.size()>1){

                            // Eğer birden fazla beacon varsa uzaklıklarına göre karşılaştırma yapılıp enYakinIndis bulunur
                            
                            if(y==0){enYakinIndis=0;}
                            if(y>0){
                                if(distance.get(y)>distance.get(y-1)){enYakinIndis=y-1;}
                                else if(distance.get(y)<=distance.get(y-1)){enYakinIndis=y;}
                            }
                        }

                    }
                    uuid=list.get(enYakinIndis).getProximityUUID().toString();
                    major=list.get(enYakinIndis).getMajor();
                    minor=list.get(enYakinIndis).getMinor();
                    data.put("ogrenci_adisoyadi",ad);
                    data.put("ogrenci_numarasi", numara);
                    data.put("beacon_uuid",uuid);
                    data.put("beacon_major",major);
                    data.put("beacon_minor",minor);

                    // Web servisimize işlem yapılmak üzere;
                    // Parametre olarak yolladığımız d,soyad ve burada enYakınIndıs değerinde beaconın UUID,Major,Minor değerleri gönderilir.
                    
                    AsyncDataClass asyncRequestObject = new AsyncDataClass();
                    asyncRequestObject.execute(serverUrl, ad, numara,uuid,String.valueOf(major),String.valueOf(minor));
                }

            }
        });
        longTask();
        // beacon manager e bağlanır. setRanging ile etraftaki beaconlar taranır.
        beaconManager.connect(new BeaconManager.ServiceReadyCallback() {
            @Override
            public void onServiceReady() {
                beaconManager.startRanging(new Region("rid", null
                        , null, null));
            }
        });
        beaconManager.disconnect();
        beaconManager.setForegroundScanPeriod(6000,6000);


    }
    private class AsyncDataClass extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... params) {
            HttpParams httpParameters = new BasicHttpParams();
            HttpConnectionParams.setConnectionTimeout(httpParameters, 5000);
            HttpConnectionParams.setSoTimeout(httpParameters, 5000);
            HttpClient httpClient = new DefaultHttpClient(httpParameters);
            HttpPost httpPost = new HttpPost(params[0]);
            String jsonResult = "";
            try {
                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(5);
                nameValuePairs.add(new BasicNameValuePair("ogrenci_adisoyadi", params[1]));
                nameValuePairs.add(new BasicNameValuePair("ogrenci_numarasi", params[2]));
                nameValuePairs.add(new BasicNameValuePair("beacon_uuid", params[3]));
                nameValuePairs.add(new BasicNameValuePair("beacon_major", params[4]));
                nameValuePairs.add(new BasicNameValuePair("beacon_minor", params[5]));
                httpPost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpClient.execute(httpPost);

                 // Web Servisimize parametre olarak aldığımız 
                // ogrenci_adisoyadi, ogrenci_numarasini, beacon_uuid, beacon_major ve beacon_minor u döndürüyoruz.
                // Post İşlemini doingBackgroundun yani; Execute(çalıştığı) yaptığımız anda yolluyor.

                jsonResult = inputStreamToString(response.getEntity().getContent()).toString();
            } catch (ClientProtocolException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
                return jsonResult;
        }
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }
        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            System.out.println("Resulted Value: " + result);

            if(result.equals("") || result == null){
                Toast.makeText(context, "Server connection failed", Toast.LENGTH_LONG).show();
                return;
            }

            int jsonResult = returnParsedJsonObject(result);
            // Gelen veriyi succes veya error mesajına göre alıp,1 e ve 0 göre işlemler yapılıyor.
            i++;
            if(i==1) {

                         // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                        // Eğer 0 dönüyorsa beacon ile eşleşen dersin o saatte dersi yoktur.
                        // Bu yüzden signingOffActivity sınıfına, "Ders yok" mesajı gönderiyor.

                if (jsonResult == 0) {
    
                    Intent i = new Intent(context.getApplicationContext(), signingOffActivity.class);
                    i.putExtra("dersAdi", "Ders Yok");
                    i.putExtra("ad", ad);
                    i.putExtra("numara", numara);
                    i.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    context.startActivity(i);
                    return;
                }

                         // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                        // Eğer 1 dönüyorsa beacon ile eşleşen dersin o saatte Nesnelerin interneti dersi vardır.
                        // Bu yüzden signingOffActivity sınıfına,  "Nesnelerin interneti" mesajı gönderiyor.

                if (jsonResult == 1) {
                    
                    Intent i = new Intent(context.getApplicationContext(), signingOffActivity.class);
                    i.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    i.putExtra("ad", ad);
                    i.putExtra("numara", numara);
                    i.putExtra("dersAdi", "Nesnelerin interneti");
                    context.startActivity(i);
                    
                }

                        // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                        // Eğer 0 dönüyorsa beacon ile eşleşen dersin o saatte Derleyici tasarimi dersi vardır.
                        // Bu yüzden signingOffActivity sınıfına, "Derleyici tasarimi" mesajı gönderiyor.

                if (jsonResult == 2) {

                    Intent i = new Intent(context.getApplicationContext(), signingOffActivity.class);
                    i.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    i.putExtra("ad", ad);
                    i.putExtra("numara", numara);
                    i.putExtra("dersAdi", "Derleyici tasarimi");
                    context.startActivity(i);

                }

                        // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                        // Eğer 0 dönüyorsa beacon ile eşleşen dersin o saatte Mobil Uygulama Geliştirme vardır.
                        // Bu yüzden signingOffActivity sınıfına, "Mobil Uygulama Geliştirme" mesajı gönderiyor.

                if (jsonResult == 3) {
                   
                    Intent i = new Intent(context.getApplicationContext(), signingOffActivity.class);
                    i.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    i.putExtra("ad", ad);
                    i.putExtra("numara", numara);
                    i.putExtra("dersAdi", "Mobil Uygulama Geliştirme");
                    context.startActivity(i);

                }

                        // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                        // Eğer 0 dönüyorsa beacon ile eşleşen dersin o saatte Optimizasyon vardır.
                        // Bu yüzden signingOffActivity sınıfına, "Optimizasyon" mesajı gönderiyor.

                if (jsonResult == 4) {
                    
                    Intent i = new Intent(context.getApplicationContext(), signingOffActivity.class);
                    i.putExtra("ad", ad);
                    i.putExtra("numara", numara);
                    i.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    i.putExtra("dersAdi", "Optimizasyon");
                    context.startActivity(i);

                }
            }else{
                beaconManager.disconnect();
            }

        }
        private StringBuilder inputStreamToString(InputStream is) {
            String rLine = "";
            StringBuilder answer = new StringBuilder();
            BufferedReader br = new BufferedReader(new InputStreamReader(is));
            try {
                while ((rLine = br.readLine()) != null) {
                    answer.append(rLine);
                }
            } catch (IOException e) {
// TODO Auto-generated catch block
                e.printStackTrace();
            }
            return answer;
        }


    }

    private int returnParsedJsonObject(String result){

             // Web servisimizden {"success",1} veya {"error",0} json mesajı döndürüyor. 
            // Bu mesajı ayrıştırmak için JsonParsedObject metodunu kullanıyoruz.
            // succes ise 1 ; error ise 0 geri döndürüyor.
            //Biz burada kullandığımız web servisimizde ise {"success",1},{"success",2},{"success",3},{"success",4} olarak yolluyoruz.
            // Buna göre OnPostExecute de işlemleri yapıyoruz.

        JSONObject resultObject = null;
        int returnedResult = 0;
        try {
            // gelen veriye göre değer döndürme işlemi yapılacak.
            resultObject = new JSONObject(result);
            returnedResult = resultObject.getInt("success");

        } catch (JSONException e) {
            e.printStackTrace();
        }
        return returnedResult;
    }

    double getDistance(int rssi, int txPower) {
        //Uzaklık bulunur.
        return Math.pow(10d, ((double) txPower - rssi) / (10 * 2));
    }
    private void longTask() {
        try {
            Thread.sleep(3000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }

}

