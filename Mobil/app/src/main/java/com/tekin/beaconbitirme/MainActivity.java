package com.tekin.beaconbitirme;

import android.Manifest;
import android.annotation.TargetApi;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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

public class MainActivity extends AppCompatActivity  {
    private static final int PERMISSION_REQUEST_COARSE_LOCATION = 1;

    protected EditText username;
    private EditText password;
    protected String enteredUsername;

    String enteredPassword;
    String uye_ismi;
    private final String serverUrl = "http://10.7.82.170:8088/giris.php";
    SharedPreferences pref;
    SharedPreferences.Editor editor;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        username = (EditText)findViewById(R.id.input_email);
        password = (EditText)findViewById(R.id.input_password);
        Button loginButton = (Button)findViewById(R.id.btn_login);

        // Android 5.0 üzeri android telefonlar için konum bilgisi de açık olması gerekir.Konum bilgisinin açılmasını burada gerçekleştiriyoruz.

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            // Android M Permission check
            if (this.checkSelfPermission(Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
                final AlertDialog.Builder builder = new AlertDialog.Builder(this);
                builder.setTitle("This app needs location access");
                builder.setMessage("Please grant location access so this app can detect beacons in the background.");
                builder.setPositiveButton(android.R.string.ok, null);
                builder.setOnDismissListener(new DialogInterface.OnDismissListener() {

                    @TargetApi(23)
                    @Override
                    public void onDismiss(DialogInterface dialog) {
                        requestPermissions(new String[]{Manifest.permission.ACCESS_COARSE_LOCATION},
                                PERMISSION_REQUEST_COARSE_LOCATION);
                    }

                });
                builder.show();
            }
        }
        pref = getSharedPreferences("login.conf", Context.MODE_PRIVATE);
        uye_ismi=pref.getString("username","");
        editor = pref.edit();
        loginButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                enteredUsername = username.getText().toString();
                enteredPassword = password.getText().toString();

                // Edittext deki verileri çekiyoruz.

                HashMap data = new HashMap();
                if(uye_ismi.equals("")){
                    if (enteredUsername.equals("") || enteredPassword.equals("")) {

                        //Eğer edittexteki değerler boş ise hata mesajı veriyor.

                        final ProgressDialog pd = new ProgressDialog(MainActivity.this);
                        pd.setMessage("Giris Yapiliyor..");
                        pd.show();
                        new Thread(new Runnable() {
                            @Override
                            public void run() {
                                try {
                                    Thread.sleep(2000);
                                    pd.dismiss();
                                    final AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
                                    builder.setMessage("Eksik Sifre ");

                                    builder.setNeutralButton("TAMAM", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialogInterface, int i) {
                                            return;
                                        }
                                    });


                                    builder.show();

                                } catch (InterruptedException e) {
                                    e.printStackTrace();
                                }
                            }
                        }).start();
                    }
                    if (enteredUsername.length() <= 1 || enteredPassword.length() <= 1) {

                        // 

                        final ProgressDialog pd = new ProgressDialog(MainActivity.this);
                        pd.setMessage("Giris Yapiliyor..");
                        pd.show();
                        new Thread(new Runnable() {
                            @Override
                            public void run() {
                                try {
                                    Thread.sleep(2000);
                                    pd.dismiss();
                                    final AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
                                    builder.setMessage("Username or password length must be greater than one");

                                    builder.setNeutralButton("TAMAM", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface dialogInterface, int i) {
                                            return;
                                        }
                                    });


                                    builder.show();

                                } catch (InterruptedException e) {
                                    e.printStackTrace();
                                }
                            }
                        }).start();
                    }
                }
                if(!uye_ismi.equals("")){
                    Toast.makeText(getApplicationContext(),"Zaten giriş yapmış bulunmaktasınız..",Toast.LENGTH_LONG).show();
                    final ProgressDialog pd = new ProgressDialog(MainActivity.this);
                    pd.setMessage("Giris Yapiliyor..");
                    pd.show();
                    new Thread(new Runnable() {
                        @Override
                        public void run() {
                            try {
                                Thread.sleep(2000);
                                pd.dismiss();


                            } catch (InterruptedException e) {
                                e.printStackTrace();
                            }
                        }
                    }).start();



                }

                // Edittextten alınan değerler POST işlemi ile Web Servise yollanır. 

                data.put("ogrenci_adisoyadi",enteredUsername);
                data.put("ogrenci_numarasi", enteredPassword);

                // Edittext teki aldığımız verileri web servise yolluyoruz.

                AsyncDataClass1 asyncRequestObject = new AsyncDataClass1();
                asyncRequestObject.execute(serverUrl, enteredUsername, enteredPassword);
            }
        });

    }

    private class AsyncDataClass1 extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... params) {
            HttpParams httpParameters = new BasicHttpParams();
            HttpConnectionParams.setConnectionTimeout(httpParameters, 5000);
            HttpConnectionParams.setSoTimeout(httpParameters, 5000);
            HttpClient httpClient = new DefaultHttpClient(httpParameters);
            HttpPost httpPost = new HttpPost(params[0]);
            String jsonResult = "";
            try {
                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
                nameValuePairs.add(new BasicNameValuePair("ogrenci_adisoyadi", params[1]));
                nameValuePairs.add(new BasicNameValuePair("ogrenci_numarasi", params[2]));
                httpPost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpClient.execute(httpPost);

                 // Web Servisimize parametre olarak aldığımız 
                // ogrenci_adisoyadi ve ogrenci_numarasini döndürüyoruz.
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
                Toast.makeText(getApplicationContext(), "Server connection failed", Toast.LENGTH_LONG).show();
                return;
            }

            // Gelen veriyi succes veya error mesajına göre alıp,1 e ve 0 göre işlemler yapılıyor.

            int jsonResult = returnParsedJsonObject(result);
            if(jsonResult == 0){
                Toast.makeText(getApplicationContext(), "Invalid username or password", Toast.LENGTH_LONG).show();

                return;
            }
                         // OnPostexecute anında yani çalıştırdıktan sonra;
                        // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                       //Eğer 0 dönüyorsa kullanıcı girişi yapılmıyor ve Yeniden sayfa yenileniyor.

            if(jsonResult == 1){
                editor.putString("username",enteredUsername);
                editor.putString("password",enteredPassword);
                editor.apply();
                final Intent intent = new Intent(MainActivity.this, LoginActivity.class);
                intent.putExtra("USERNAME", enteredUsername);
                intent.putExtra("NUMARA",enteredPassword);
                intent.putExtra("MESSAGE", "succes");
                startActivity(intent);

                         // Web serviste yaptığımız işlemler soncu returParseObject metodu ile
                       // Eğer 1 dönerse kullanıcı girişi yapılıyor ve verileri LoginActivity e gönderiyor.
                
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

    private int returnParsedJsonObject(String result){
        JSONObject resultObject = null;
        int returnedResult = 0;
        try {

             // Web servisimizden {"success",1} veya {"error",0} json mesajı döndürüyor. 
            // Bu mesajı ayrıştırmak için JsonParsedObject metodunu kullanıyoruz.
            // succes ise 1 ; error ise 0 geri döndürüyor.

            resultObject = new JSONObject(result);
            returnedResult = resultObject.getInt("success");

        } catch (JSONException e) {
            e.printStackTrace();
        }
        return returnedResult;
    }
}