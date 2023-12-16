

Step 1: In order to display a content using views, you need to have a content type.
Suppose you have a content type named 'sample' with fields name(machine-name:title) and email(machine-name:field_e_mail).

step 2: Create a page view of 'sample' content type.

step 3: Create a menu using which you need to show the page.
For Eg: I am using the menu add/user

    /**
    * Implements hook_menu().
    */
     function hook_menu() {
          $items = array();
          $items['add/user'] = array(
            'title' => 'Add user ',
            'description' => '',
            'page callback' => 'MYMODULENAME_custom_page_display', //custom function to display the page.
            'access arguments' => array('PERMISSION NAME'),  // You can give permission if you want.
            'type' => MENU_NORMAL_ITEM,
          );
          return $items;
    }



step 4 : Create a custom form.
This step includes creating custom form, its submission function, theme function(if any) and validation function.
As an example I'll show you a sample form and its submission function.

         /**
         * Custom form.
         */

         function MYMODULENAME_sample_form($form, &$form_state) {
            $form['name'] = array(
              '#type' => 'textfield',
              '#title' => t('Name'),
              '#required' => TRUE,
              '#size' => 10,

            );
            $form['email'] = array(
              '#type' => 'textfield',
              '#title' => t('Email'),
              '#required' => TRUE,
              '#size' => 10,

            );
            $form['submit'] = array(
              '#type' => 'submit',
              '#value' => 'Submit',
            );
            return $form;
          }
          ?>

          In the submit function I am going to save these values as a new node of 'sample' content-type, so that you can see these values in the view.
          <?php
          /**
          * defines user form submit.
          */
          function MYMODULENAME_sample_form($form, &$form_state) {
            global $user;
            $node =  new stdClass();
            $node->type = 'sample'; //machine name of created content type.
            $node->title = $form_state['values']['name'];
            $node->field_e_mail['und'][0]['value'] = (string)$form_state['values']['email'];
            $node->promote = 1;
            $node->language = 'und';
            $node->status =1;
            $node->uid = $user->uid;
            node_save($node);
          }

step 5 : Define the page function

Now that we have our form and view, we can define the page function which we've declared inside the menu hook.

    /**
    * The below function displays a page which is embeded with custom sample form and the view.
    *
    */
    function MYMODULENAME_custom_page_display() {
      //Calling the sample form.
      $output = render(drupal_get_form('MYMODULENAME_sample_form')); // Calling the form

      //Programatically calling a view which is already created.
      $output .= views_embed_view('sample_list','page'); // the first argument is the machine name of view and second is its display name.
      return $output;
    }


