//package com.example.hello.world;
//
//import android.os.Bundle;
//import android.app.TabActivity;
//import android.content.Intent;
//import android.content.res.Resources;
//import android.widget.TabHost;
//import android.widget.TabHost.TabSpec;
//
//public class ViewScreenActivity extends TabActivity {
//
//	public void onCreate(Bundle savedInstanceState) {
//	    super.onCreate(savedInstanceState);
//	    setContentView(R.layout.view_screen);
//
//	    Resources ressources = getResources();
//	    TabHost tabHost = getTabHost();
//	    
//	    // View Tab
//	    Intent intentView = new Intent().setClass(this, TabWidgetViewActivity.class); 
//	    TabSpec tabSpecView = tabHost
//	    		.newTabSpec("View") 
//	    		.setIndicator("", ressources.getDrawable(R.drawable.ic_tab_view))
//	    		.setContent(intentView);
//	    		
//   	    // Edit Tab
//   	    Intent intentEdit = new Intent().setClass(this, TabWidgetViewActivity.class); 
//   	    TabSpec tabSpecEdit = tabHost
//   	    		.newTabSpec("Edit") 
//   	    		.setIndicator("", ressources.getDrawable(R.drawable.ic_tab_widget_edit))
//   	    		.setContent(intentEdit);		
//	    				
//	    // Exit Tab
//	    Intent intentExit = new Intent().setClass(this, TabWidgetViewActivity.class); 
//	    TabSpec tabSpecExit = tabHost
//	    		.newTabSpec("Exit") 
//	    		.setIndicator("", ressources.getDrawable(R.drawable.ic_tab_widget_exit))
//	    		.setContent(intentExit); 			
//	    
//	    // Add Tabs
//	    tabHost.addTab(tabSpecView);
//	    tabHost.addTab(tabSpecEdit);
//	    tabHost.addTab(tabSpecExit);
//	    
//	    // Default Tab
//	    tabHost.setCurrentTab(1);
//	}
//
//}
