package com.example.hello.world;

import android.os.Bundle;
import android.app.Activity;
import android.app.TabActivity;
import android.content.Intent;
import android.content.res.Resources;
import android.view.Menu;
import android.widget.TabHost;

public class ViewScreenActivity extends TabActivity {

	public void onCreate(Bundle savedInstanceState) {
	    super.onCreate(savedInstanceState);
	    setContentView(R.layout.view_screen);

	    Resources res = getResources(); // Resource object to get Drawables
	    TabHost tabHost = getTabHost();  // The activity TabHost
	    TabHost.TabSpec spec;  // Resusable TabSpec for each tab
	    Intent intent;  // Reusable Intent for each tab

	    // Create an Intent to launch an Activity for the tab (to be reused)
	    intent = new Intent().setClass(this, TabWidgetViewActivity.class);

	    // Initialize a TabSpec for each tab and add it to the TabHost
	    spec = tabHost.newTabSpec("view").setIndicator("View",
	                      res.getDrawable(R.drawable.ic_action_tabwidgetedit))
	                  .setContent(intent);
	    tabHost.addTab(spec);

	    // Do the same for the other tabs
	    intent = new Intent().setClass(this, TabWidgetViewActivity.class);
	    spec = tabHost.newTabSpec("edit").setIndicator("Edit",
	                      res.getDrawable(R.drawable.ic_action_tabwidgetlogout))
	                  .setContent(intent);
	    tabHost.addTab(spec);

	    intent = new Intent().setClass(this, TabWidgetViewActivity.class);
	    spec = tabHost.newTabSpec("Exit").setIndicator("Exit",
	                      res.getDrawable(R.drawable.ic_action_tabwidgetedit))
	                  .setContent(intent);
	    tabHost.addTab(spec);

	    tabHost.setCurrentTab(1);
	}

}
