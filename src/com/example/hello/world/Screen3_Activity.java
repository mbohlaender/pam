package com.example.hello.world;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;

public class Screen3_Activity extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		setContentView(R.layout.screen_3);
	}
	
    public void onButtonClick(View view) {
    	
    	if (view.getId() == R.id.button2) {
    		startActivity(new Intent(this, Screen1_Activity.class));
    	}
    	if (view.getId() == R.id.button1) {
    		startActivity(new Intent(this, Screen1_Activity.class));
    	}
    	
    }

}
