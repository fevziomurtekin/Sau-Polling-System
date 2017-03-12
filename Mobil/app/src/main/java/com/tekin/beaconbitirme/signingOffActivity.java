package com.tekin.beaconbitirme;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

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
 * Created by Ömür on 27.01.2017.
 */
public class signingOffActivity extends Activity {
    int dersVarmi=1;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.signing);
        final TextView ders= (TextView) findViewById(R.id.textView);
        TextView ad= (TextView) findViewById(R.id.textView1);
        TextView numara=(TextView)findViewById(R.id.textView2);
        Button imza= (Button) findViewById(R.id.btn_imza);
        final String serverUrl = "http://10.7.82.170:8088/imza.php";

        Intent i=getIntent();
        Bundle intentBundle = i.getExtras();
        final String dersinAdi = intentBundle.getString("dersAdi");
        final String ogrenciAdi=intentBundle.getString("ad");
        final String ogrenciNumara=intentBundle.getString("numara");
        ders.setText(dersinAdi);
        ad.setText(ogrenciAdi);
        numara.setText(ogrenciNumara);

        if(dersinAdi.equals("Ders Yok")){imza.setText("Anasayfaya Dön");
        dersVarmi=0;}
        imza.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                HashMap data = new HashMap();
                if(dersVarmi==1) {

                    // Derse imza atılma işlemi yapılıyor.

                    final ProgressDialog pd = new ProgressDialog(signingOffActivity.this);
                    pd.setMessage("İmza atılıyor..");
                    pd.show();
                    Thread thread = new Thread() {
                        @Override
                        public void run() {
                            try {
                                synchronized (this) {
                                    wait(3000);
                                    pd.dismiss();


                                }
                            } catch (InterruptedException ex) {
                            }

                            // TODO
                        }
                    };

                    thread.start();
                    data.put("imza_ders",dersinAdi);
                    data.put("imza_adisoyadi", ogrenciAdi);
                    data.put("imza_numarasi",ogrenciNumara);
                    AsyncDataClass asyncRequestObject = new AsyncDataClass();
                    asyncRequestObject.execute(serverUrl,dersinAdi, ogrenciAdi,ogrenciNumara);
                }
                if(dersVarmi==0){

                    // Eğer ders yoksa imza at butonu yerine anasayfaya yönlendirme işlemi yapılıyor.

                    final Intent i=new Intent(getApplicationContext(),MainActivity.class);
                    final ProgressDialog pd = new ProgressDialog(signingOffActivity.this);
                    pd.setMessage("Anasayfaya yönlendiriliyorsunuz..");
                    pd.show();
                    new Thread(new Runnable() {
                        @Override
                        public void run() {
                            try {
                                Thread.sleep(2000);
                                pd.dismiss();
                                startActivity(i);

                            } catch (InterruptedException e) {
                                e.printStackTrace();
                            }
                        }
                    }).start();


                }

            }
        });


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

                // Web Servisimize parametre olarak aldığımız 
                // imza_ders,imza_adisoyadi ve imza_numarasini döndürüyoruz.
                // Post İşlemini doingBackgroundun yani; Execute(çalıştığı) yaptığımız anda yolluyor.


                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
                nameValuePairs.add(new BasicNameValuePair("imza_ders", params[1]));
                nameValuePairs.add(new BasicNameValuePair("imza_adisoyadi", params[2]));
                nameValuePairs.add(new BasicNameValuePair("imza_numarasi", params[3]));
                httpPost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpClient.execute(httpPost);
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
                Toast.makeText(getApplicationContext(), "Server connection failed", Toast.LENGTH_LONG).show();
                return;
            }
            int jsonResult = returnParsedJsonObject(result);
            if(jsonResult == 0){
                final Intent intent = new Intent(signingOffActivity.this, MainActivity.class);
                AlertDialog.Builder builder = new AlertDialog.Builder(signingOffActivity.this);
                builder.setTitle("İmza");
                builder.setMessage("Önceden bu ders için imza atmıştınız.Anasayfaya yönlendiriyoruz.");
                builder.setNeutralButton("Tamam", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        longTask();
                        startActivity(intent);

                        // OnPostexecute anında yani çalıştırdıktan sonra;
                        // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                        // 0 dönüyorsa daha önceden imza atılmış demektir.
                        // Bu yüzden alertdialog mesajı geri döndürüyor.İmza işlemi gerçekleştirilmemiş oluyor.

                    }
                });

                builder.show();
            }

            if(jsonResult == 1){
                final Intent intent = new Intent(signingOffActivity.this, MainActivity.class);
                AlertDialog.Builder builder = new AlertDialog.Builder(signingOffActivity.this);
                builder.setTitle("İmza");
                builder.setMessage("İmzayı Başarı ile attınız!");
                builder.setNeutralButton("Tamam", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        longTask();
                        startActivity(intent);

                        // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                        // 1 dönüyorsa daha önceden imza atılmamış demektir.
                        // İmza atılıyor ve İmza attığını söyleyen alertdialog mesajı geliyor.

                    }
                });
                builder.show();



            }
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

    // Web servisimizden {"success",1} veya {"error",0} json mesajı döndürüyor. 
    // Bu mesajı ayrıştırmak için JsonParsedObject metodunu kullanıyoruz.
    // succes ise 1 ; error ise 0 geri döndürüyor.

    private int returnParsedJsonObject(String result){
        JSONObject resultObject = null;
        int returnedResult = 0;
        try {
            resultObject = new JSONObject(result);
            returnedResult = resultObject.getInt("success");

        } catch (JSONException e) {
            e.printStackTrace();
        }
        return returnedResult;
    }
    private void longTask() {
        try {
            Thread.sleep(5000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }

}