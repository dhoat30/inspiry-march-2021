<?php 
function webduelSocialShareFunction() {
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return '
    <div class="social-share">
        <a target="_blank" href="https://www.pinterest.com/pin/create/button?url='.$actual_link.'" rel="noreferrer" aria-label="pinterest share">
        <svg xmlns="http://www.w3.org/2000/svg" width="15.217" height="18.729" viewBox="0 0 15.217 18.729">
        <path id="XMLID_215_" d="M9.863,0C4.73,0,2,3.29,2,6.876c0,1.663.929,3.738,2.417,4.4.226.1.349.059.4-.151.044-.159.24-.926.335-1.288a.331.331,0,0,0-.08-.325A4.265,4.265,0,0,1,4.186,6.92,5.045,5.045,0,0,1,9.559,1.989c2.927,0,4.974,1.9,4.974,4.621,0,3.073-1.626,5.2-3.739,5.2A1.674,1.674,0,0,1,9.03,9.755a22.256,22.256,0,0,0,.988-3.781,1.452,1.452,0,0,0-1.5-1.6c-1.191,0-2.156,1.179-2.156,2.762a3.937,3.937,0,0,0,.356,1.685l-1.4,5.646a12.634,12.634,0,0,0,.087,4.15.123.123,0,0,0,.225.057,14.749,14.749,0,0,0,1.939-3.651c.145-.535.741-2.7.741-2.7a3.236,3.236,0,0,0,2.73,1.3c3.587,0,6.179-3.153,6.179-7.065C17.2,2.806,13.994,0,9.863,0" transform="translate(-2)" fill="#d32f2f"/>
      </svg>
      
      
        </a>
        <a target="_blank" href="https://www.facebook.com/sharer.php?u='.$actual_link.'" rel="noreferrer" aria-label="Facebook Share">
        <svg xmlns="http://www.w3.org/2000/svg" width="9.986" height="19.229" viewBox="0 0 9.986 19.229">
        <path id="Path_51" data-name="Path 51" d="M94.91,32.059V23.287h2.944l.441-3.418H94.91V17.686c0-.99.275-1.664,1.694-1.664h1.81V12.964a24.261,24.261,0,0,0-2.638-.135c-2.61,0-4.4,1.593-4.4,4.519v2.521H88.428v3.418H91.38v8.772h3.53Z" transform="translate(-88.428 -12.829)" fill="#3c5a9a"/>
      </svg>
      
      
        </a>
      
        <a target="_blank" href="mailto:?subject=I wanted you to see this product&body=Check out this product '.$actual_link.'" rel="noreferrer" aria-label="Mail Share">
        <svg xmlns="http://www.w3.org/2000/svg" width="25.276" height="19.229" viewBox="0 0 25.276 19.229">
        <g id="XMLID_146_" transform="translate(-2 -123)">
          <path id="XMLID_211_" d="M54.291,196.249a2.386,2.386,0,0,1-1.73.748h-.03A2.369,2.369,0,0,1,50.8,196.2L42,187.7v13.134c0,.575.3.907.471.907H62.84c.173,0,.471-.327.471-.907V187.992Z" transform="translate(-38.018 -61.493)" fill="none"/>
          <path id="XMLID_415_" d="M81.788,171.076l.03.035a.4.4,0,0,0,.3.144.406.406,0,0,0,.307-.134l.03-.035.035-.03,9.089-8.311-9.377.015-9.1-.059Z" transform="translate(-67.576 -37.732)" fill="none"/>
          <path id="XMLID_426_" d="M24.808,123.025l-10.175.025L4.458,123h0A2.683,2.683,0,0,0,2,125.889V139.34a2.683,2.683,0,0,0,2.453,2.889H24.823a2.683,2.683,0,0,0,2.453-2.889V125.889A2.654,2.654,0,0,0,24.808,123.025Zm-.8,1.982-9.089,8.311-.035.03-.03.035a.406.406,0,0,1-.307.134.391.391,0,0,1-.3-.144l-.03-.035-8.688-8.371,9.1.059,9.377-.02Zm.813,15.24H4.453c-.173,0-.471-.327-.471-.907V126.207l8.8,8.5a2.391,2.391,0,0,0,1.745.793h.03a2.366,2.366,0,0,0,1.725-.748L25.3,126.5V139.34C25.293,139.92,25,140.247,24.823,140.247Z" transform="translate(0)" fill="#010002"/>
        </g>
      </svg>
      
      
         </a>
    </div>';
}

add_shortcode('webduelSocialShare', 'webduelSocialShareFunction'); 