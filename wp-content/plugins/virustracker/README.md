# Virustrack Plugin
## Files
**api-test.php**  
Just for testing successfull curl executions  
**index.php**  
Just for no one abusing directory listings  
**virustracker.php**  
Main file which is executed by wordpress. Points to other plugin files.  
  
**includes/[frontend-submit-form.php](https://github.com/virustracker/vt-web/blob/master/wp-content/plugins/virustracker/includes/frontend-submit-form.php "frontend-submit-form.php")**  
Renders the form for labs, to submit test code and result.  
**includes/[index.php](https://github.com/virustracker/vt-web/blob/master/wp-content/plugins/virustracker/includes/index.php "index.php")**  
Just for no one abusing directory listings  
**includes/[plugin-options.php](https://github.com/virustracker/vt-web/blob/master/wp-content/plugins/virustracker/includes/plugin-options.php "plugin-options.php")**  
Renders the plugin options in the wordpress backend (API URL, API Key, Page ID of the page submitting the results)  
**includes/[submit-test.php](https://github.com/virustracker/vt-web/blob/master/wp-content/plugins/virustracker/includes/submit-test.php "submit-test.php")**  
The magic happens here. API Call is made.  
