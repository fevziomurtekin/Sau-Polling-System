package com.tekin.beaconbitirme;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.widget.ImageButton;
import android.widget.TextView;

/**
 * Created by Ömür on 25.01.2017.
 */

public class LoginActivity extends ActionBarActivity {
    String ders;
    String loggedUsername;
    ImageButton button;
    String message="İmza ekranına yönlendiriliyorsunuz..";
    Beacon beacon;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        int i=0;
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        Intent intent = getIntent();
        Bundle intentBundle = intent.getExtras();
        final String loggedUser = intentBundle.getString("USERNAME");
        final String loggedNumber = intentBundle.getString("NUMARA");

        //Login yaptıktan sonra Giriş yapan kişinin adını-soyadını ve numarasını alıp hoşgeldin diyoruz.

        try {
            loggedUsername = capitalizeFirstCharacter(loggedUser);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
        final TextView loginUsername = (TextView) findViewById(R.id.login_user);
        loginUsername.setText(loggedUser);

        final String finalLoggedUser = loggedUser;
        final String finalMessage = message;


        if (finalLoggedUser != null) {


            try {
                beacon = new Beacon(getApplicationContext(), loggedUser, loggedNumber);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }


            // TODO
        }
    }


    // Bu metotta adısoyadının harflerini büyütüyoruz.

    private String capitalizeFirstCharacter(String textInput) throws InterruptedException {

        String output = textInput.toUpperCase();
        return output;    }





}
