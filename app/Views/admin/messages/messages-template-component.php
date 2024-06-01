<?php ?>

<!DOCTYPE html>
<html>
   <head>
      <title><?= SITE_NAME ?></title>
      <link rel="icon" href="<?= base_url('assets/cms/img/favicon.ico'); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('assets/cms/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
   </head>
   <body>
      <div id="mailsub" class="notification" align="center">
         <table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;">
            <tr>
               <td align="center" bgcolor="#eff3f8">
                  <table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%" style="max-width: 680px; min-width: 300px;">
                     <tr>
                        <td>
                           <!-- padding -->
                           <div style="height: 80px; line-height: 80px; font-size: 10px;"></div>
                        </td>
                     </tr>
                     <!--header -->
                     <tr>
                        <td align="center" bgcolor="#ffffff">
                           <!-- padding -->
                           <div style="height: 30px; line-height: 30px; font-size: 10px;"></div>
                           <table width="90%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;">
                                       <table class="mob_center" width="355" border="0" cellspacing="0" cellpadding="0" align="left" style="border-collapse: collapse;">
                                          <tr>
                                             <td align="left" valign="middle">
                                                <!-- padding -->
                                                <div style="height: 20px; line-height: 20px; font-size: 10px;"></div>
                                                <table width="355" border="0" cellspacing="0" cellpadding="0">
                                                   <tr>
                                                      <td align="left" valign="top" class="mob_center">
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <a href="<?php echo base_url(); ?>" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 20px;">
                                                                        <font face="Arial, Helvetica, sans-seri; font-size: 13px;" size="3" color="#596167">
                                                                           <img src="https://yandaaa.com/no-images.jpg" width="80" height="80" alt="<?= SITE_NAME ?>" border="0" style="display: block;" />
                                                                        </font>
                                                                     </a>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        </table>
                                                      </td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                    </div>
                                    <div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;">
                                       <table width="88" border="0" cellspacing="0" cellpadding="0" align="right" style="border-collapse: collapse;">
                                          <tr>
                                             <td align="right" valign="middle">
                                                <!-- padding -->
                                                <div style="height: 20px; line-height: 20px; font-size: 10px;"></div>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                   <tr>
                                                      <td align="right"></td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                    </div>
                                    <!-- Item END-->
                                 </td>
                              </tr>
                           </table>
                           <!-- padding -->
                           <div style="height: 50px; line-height: 50px; font-size: 10px;"></div>
                        </td>
                     </tr>
                     <!--header END-->
                     <!--content 1 -->
                     <tr>
                        <td align="center" bgcolor="#fbfcfd">
                           <table width="90%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="left">
                                    <!-- padding -->
                                    <div style="height: 60px; line-height: 60px; font-size: 10px;"></div>
                                    <div style="line-height: 44px;">
                                       <font face="Arial, Helvetica, sans-serif" size="5" color="#57697e" style="font-size: 34px;">
                                          <span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">
                                             Hi <?php echo ucwords(strtolower($data['name'])); ?>!
                                          </span>
                                       </font>
                                    </div>
                                    <!-- padding -->
                                    <div style="height: 40px; line-height: 30px; font-size: 10px;"></div>
                                 </td>
                              </tr>
                              <tr>
                                 <td align="left">
                                    <div style="line-height: 24px;">
                                       <font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;">
                                          <span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">
                                            <p>
                                              <?php echo $data['message']; ?>
                                            </p>
                                          </span>
                                       </font>
                                    </div>
                                    <!-- padding -->
                                    <div style="height: 40px; line-height: 40px; font-size: 10px;"></div>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <!--content 1 END-->
                     <!--footer -->
                     <tr>
                        <td class="iage_footer" align="center" bgcolor="#ffffff">
                           <!-- padding -->
                           <div style="height: 80px; line-height: 80px; font-size: 10px;"></div>

                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                 <td align="center">                                                  
                                    <!--social -->
                                     <div class="mob_center_bl" style="width: 110px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                           <tr>
                                              <td width="50" align="center" style="line-height: 19px;padding-right: 10px;">
                                                 <a href="" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                    <font face="Arial, Helvetica, sans-serif" size="2" color="#596167">
                                                       <img src="https://yandaaa.com/instagram.png" width="25" height="25" alt="Facebook" border="0" style="display: block;filter: grayscale(90%);" />
                                                    </font>
                                                 </a>
                                              </td>
                                              <td width="50" align="center" style="line-height: 19px;padding-right: 10px;">
                                                 <a href="" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                    <font face="Arial, Helvetica, sans-serif" size="2" color="#596167">
                                                       <img src="https://yandaaa.com/twitter.png" width="25" height="25" alt="Twitter" border="0" style="display: block;filter: grayscale(90%);" />
                                                    </font>
                                                 </a>
                                              </td>
                                              <td width="50" align="right" style="line-height: 19px;padding-right: 10px;">
                                                 <a href="" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                                    <font face="Arial, Helvetica, sans-serif" size="2" color="#596167">
                                                       <img src="https://yandaaa.com/linkedin.png" width="25" height="25" alt="Linkedin" border="0" style="display: block;filter: grayscale(90%);" />
                                                    </font>
                                                 </a>
                                              </td>
                                           </tr>
                                        </table>
                                     </div>
                                     <!--social END-->
                                     <br>
                                    <font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5" style="font-size: 13px;">
                                       <span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
                                          <?= date('Y',strtotime("-1 year", strtotime(date('Y')))); ?>-<?= date('Y') ?> © <?= SITE_NAME; ?>. ALL Rights Reserved.
                                       </span>
                                    </font>
                                 </td>
                              </tr>
                           </table>
                           <!-- padding -->
                           <div style="height: 30px; line-height: 30px; font-size: 10px;"></div>
                        </td>
                     </tr>
                     <!--footer END-->
                     <tr>
                        <td>
                           <!-- padding -->
                           <div style="height: 80px; line-height: 80px; font-size: 10px;"></div>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>

<style type="text/css">
   body {
      padding: 0;
      margin: 0;
   }

   html {
      -webkit-text-size-adjust: none;
      -ms-text-size-adjust: none;
   }
   @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
      *[class="table_width_100"] {
         width: 96% !important;
      }
      *[class="border-right_mob"] {
         border-right: 1px solid #dddddd;
      }
      *[class="mob_100"] {
         width: 100% !important;
      }
      *[class="mob_center"] {
         text-align: center !important;
      }
      *[class="mob_center_bl"] {
         float: none !important;
         display: block !important;
         margin: 0px auto;
      }
      .iage_footer a {
         text-decoration: none;
         color: #929ca8;
      }
      img.mob_display_none {
         width: 0px !important;
         height: 0px !important;
         display: none !important;
      }
      img.mob_width_50 {
         width: 40% !important;
         height: auto !important;
      }
   }
   .table_width_100 {
      width: 680px;
   }
</style>