package com.example.zemerge;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.MalformedURLException;
import java.net.URI;
import java.net.URISyntaxException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import android.app.Activity;
import android.app.ActionBar;
import android.app.Fragment;
import android.content.Context;
import android.content.Intent;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.Environment;
import android.os.StrictMode;
import android.telephony.SmsManager;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;
import android.os.Build;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;

public class MainActivity extends Activity {
	
	Intent i; 
	Button Is;
	Button set;
	public String hospital_num="9915307999";
	public String police_num="8288909892";
	public String selfie_num="8288909771";
    EditText editText1,editText2,editText3,editText4,editText5;
    CheckBox checkBox1,checkBox2,checkBox3;
    String lati="";
    String longi="";
    String Police="";
    String Hospital="";
    String Selfie="";
    private TextView lblEstado; 
	private LocationManager locManager;
	private LocationListener locListener;
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.fragment_main);
		
	set=(Button)findViewById(R.id.button1);     //It is PM(private message) button in app
    Is= (Button) findViewById(R.id.bIs);        //INSTANT BUTTON in application
    editText1 = (EditText) findViewById(R.id.editText1);
    editText2= (EditText) findViewById(R.id.editText2);
    editText3= (EditText) findViewById(R.id.editText3);
    editText4= (EditText) findViewById(R.id.editText4);
    editText5= (EditText) findViewById(R.id.editText5);
    checkBox1= (CheckBox) findViewById(R.id.checkBox1);
    checkBox2= (CheckBox) findViewById(R.id.checkBox2);
    checkBox3= (CheckBox) findViewById(R.id.checkBox3);
  
    StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();

    StrictMode.setThreadPolicy(policy);
    
    
    
   set.setOnClickListener(new View.OnClickListener() {   //On clicking PM message it will take to another
	                                                 //page where they can call and message simultaneously
	                                                 //to any of their relative.
	                                                 //Note that this information will not go to the server
	@Override                                           
	public void onClick(View v) {
		// TODO Auto-generated method stub
		 Intent i=new Intent();
	        i.setClass(getBaseContext(), SMSActivity.class);
	        
	        startActivity(i);
	        
	}
});
   
Is.setOnClickListener(new View.OnClickListener() { //On clicking INSTANT BUTTON it will send data to database

@Override
public void onClick(View arg0) {
    // TODO Auto-generated method stub
    //postData();
	 if (checkBox1.isChecked()) {
     	Hospital="Yes";
     }
	 if (checkBox2.isChecked()) {
     	Police="Yes";
     }
	 if(checkBox3.isChecked()){
		 Selfie="Yes";
	 }
	comenzarLocalizacion();
	
	  String sms ="latitude:"+lati+",longitude:"+longi;
	  try {
			SmsManager smsManager = SmsManager.getDefault();
			if(checkBox1.isChecked())
			{
			smsManager.sendTextMessage(hospital_num, null, sms, null, null);
			}
			if(checkBox2.isChecked())
			{
			smsManager.sendTextMessage(police_num, null, sms, null, null);
			}
			if(checkBox3.isChecked())
			{
			smsManager.sendTextMessage(selfie_num, null, sms, null, null);
			}
			Toast.makeText(getApplicationContext(), "SMS Sent!",
						Toast.LENGTH_LONG).show();
		  } catch (Exception e) {
			Toast.makeText(getApplicationContext(),
				"SMS failed, please try again later!",
				Toast.LENGTH_LONG).show();
			e.printStackTrace();
		  }
        try {
			URL url = new URL("http://10.1.9.236/register.php");
		} catch (MalformedURLException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
        HttpClient client = new DefaultHttpClient();
        HttpPost request = new HttpPost();
        try {
			request.setURI(new URI("http://10.1.9.236/register.php"));
		} catch (URISyntaxException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}

        try {
        	final String culprit_name=editText1.getText().toString();
            final String culprit_vehicle_number=editText2.getText().toString();
            final String victim_name=editText3.getText().toString();
            final String victim_phone=editText4.getText().toString();
            final String victim_vehicle_nuimber=editText5.getText().toString();
           
            Is.setText("INFO SENT");
            // Add your data
        	 List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
			    nameValuePairs.add(new BasicNameValuePair("culprit_name",  culprit_name));
			    nameValuePairs.add(new BasicNameValuePair("culprit_vehicle_number",culprit_vehicle_number));
			    nameValuePairs.add(new BasicNameValuePair("victim_name", victim_name));
			    nameValuePairs.add(new BasicNameValuePair("victim_phone", victim_phone));
			    nameValuePairs.add(new BasicNameValuePair("victim_vehicle_nuimber",victim_vehicle_nuimber));
			    nameValuePairs.add(new BasicNameValuePair("latitude",lati));
			    nameValuePairs.add(new BasicNameValuePair("longitude",longi));
			    nameValuePairs.add(new BasicNameValuePair("Hospital",Hospital));
			    nameValuePairs.add(new BasicNameValuePair("Police",Police));
			    nameValuePairs.add(new BasicNameValuePair("Selfie",Selfie));
			    
			    request.setEntity(new UrlEncodedFormEntity(nameValuePairs));
			 //   HttpPost.setEntity(new UrlEncodedFormEntity(nameValuePairs,HTTP.UTF_16));

                final UrlEncodedFormEntity formEntity = new UrlEncodedFormEntity(
                        nameValuePairs);

                request.setEntity(formEntity);
                
			    HttpResponse response = client.execute(request);
			    BufferedReader in = new BufferedReader
			    (new InputStreamReader(response.getEntity().getContent()));
        } catch (ClientProtocolException e) {
            // TODO Auto-generated catch block
        } catch (IOException e) {
            // TODO Auto-generated catch block
        }

}
});


}
	
	
		
	
	
	private void comenzarLocalizacion()
    {
    	//Obtenemos una referencia al LocationManager
    	locManager = 
    		(LocationManager)getSystemService(Context.LOCATION_SERVICE);
    	
    	//Obtenemos la última posición conocida
    	Location loc = 
    		locManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
    	
    	//Mostramos la última posición conocida
    	mostrarPosicion(loc);
    	
    	//Nos registramos para recibir actualizaciones de la posición
    	locListener = new LocationListener() {
	    	public void onLocationChanged(Location location) {
	    		mostrarPosicion(location);
	    	}
	    	public void onProviderDisabled(String provider){
	    		lblEstado.setText("Provider OFF");
	    	}
	    	public void onProviderEnabled(String provider){
	    		lblEstado.setText("Provider ON ");
	    	}
	    	public void onStatusChanged(String provider, int status, Bundle extras){
	    		Log.i("", "Provider Status: " + status);
	    		lblEstado.setText("Provider Status: " + status);
	    	}
    	};
    	
    	locManager.requestLocationUpdates(
    			LocationManager.GPS_PROVIDER, 30000, 0, locListener);
    }
     
    private void mostrarPosicion(Location loc) {
    	if(loc != null)
    	{
    		lati=String.valueOf(loc.getLatitude());
    		longi=String.valueOf(loc.getLongitude());
    		
    		
    	}
    	else
    	{
    		longi="(sin_datos)";
    		lati="(sin_datos)";
    		
    	}
    }
	}

	


