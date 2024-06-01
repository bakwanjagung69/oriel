<?php

namespace App\Controllers;
use App\Models\ClassesModel;
use Config\Services;

class Files extends BaseController {
	protected $classesModel;
	protected $request;
    protected $encrypter;

    public function __construct() {
        $this->classesModel = new ClassesModel();
        $this->request = Services::request();
    }

    public function index() {
    	return view('404/component-view-404');
    }

    public function images() {
    	if (isset($_GET['q'])) {
    		
	    	$result = $this->classesModel->decrypter($_GET['q']);
	    	$resDecode = urldecode($result);
	    	$path = site_url($resDecode);

	    	$arr = explode('/', $resDecode); 
	    	$fileName = $arr[count($arr)-1];

	    	$str  = $resDecode;
		  	$file = DIR_PUBLIC_ASSETS."/{$str}";

		  	$mode = 'download'; // Default mode
		  	if (isset($_GET['mode'])) {
		  		$mode = ($_GET['mode'] == 'download') ? 'attachment' : 'inline';
		  	}

	  	 	try {
		      $mimes = mime_content_type($file);
		    } catch (\Exception $e) {
		      // die($e->getMessage());
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

		    try {
				$type = $mimes;
				header('Content-Type:'.$type);
				header('Content-Length: ' . filesize($file));
				header('Content-Disposition: '.$mode.'; filename="'.$fileName.'"');
				readfile($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

			exit(0);
    	} else {
    		return view('404/component-view-404');
    	}
    }

    public function svg() {
    	if (isset($_GET['q'])) {
    		
	    	$result = $this->classesModel->decrypter($_GET['q']);
	    	$resDecode = urldecode($result);
	    	$path = site_url($resDecode);

	    	$arr = explode('/', $resDecode); 
	    	$fileName = $arr[count($arr)-1];

	    	$str  = $resDecode;
		  	$file = DIR_PUBLIC_ASSETS."/{$str}";

		  	$mode = 'download'; // Default mode
		  	if (isset($_GET['mode'])) {
		  		$mode = ($_GET['mode'] == 'download') ? 'attachment' : 'inline';
		  	}

	  	 	try {
		      $mimes = 'image/svg+xml';
		    } catch (\Exception $e) {
		      // die($e->getMessage());
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

		    try {
				$type = $mimes;
				header('Content-Type:'.$type);
				header('Content-Length: ' . filesize($file));
				header('Content-Disposition: '.$mode.'; filename="'.$fileName.'"');
				readfile($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

			exit(0);
    	} else {
    		return view('404/component-view-404');
    	}
    }

    public function document() {
    	if (isset($_GET['q'])) {
	    	$result = $this->classesModel->decrypter($_GET['q']);
	    	$resDecode = urldecode($result);

	    	$arr = explode('/', $resDecode); 
	    	$fileName = $arr[count($arr)-1];
	    	$path = site_url($resDecode);
	    	
	    	$str  = $resDecode;
		  	$file = DIR_PUBLIC_ASSETS."/{$str}";

		  	$mode = 'download'; // Default mode
		  	if (isset($_GET['mode'])) {
		  		$mode = ($_GET['mode'] == 'download') ? 'attachment' : 'inline';
		  	}

	  	 	try {
		      $mimes = mime_content_type($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

		    try {
				$type = $mimes;
				header('Content-Type:'.$type);
				header('Content-Length: ' . filesize($file));
				header('Content-Disposition: '.$mode.'; filename="'.$fileName.'"');
				readfile($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

			exit(0);
    	} else {
    		return view('404/component-view-404');
    	}
    }

    public function videos() {
    	if (isset($_GET['q'])) {
	    	$result = $this->classesModel->decrypter($_GET['q']);
	    	$resDecode = urldecode($result);
	    	$path = site_url($resDecode);

	    	$arr = explode('/', $resDecode); 
	    	$fileName = $arr[count($arr)-1];

	    	$str  = $resDecode;	    	
		  	$file = DIR_PUBLIC_ASSETS."/{$str}";

		  	$mode = 'download'; // Default mode
		  	if (isset($_GET['mode'])) {
		  		$mode = ($_GET['mode'] == 'download') ? 'attachment' : 'inline';
		  	}

	  	 	try {
		      $mimes = mime_content_type($file);
		    } catch (\Exception $e) {
		      // die($e->getMessage());
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

		    try {
				$type = $mimes;
				header('Content-Type:'.$type);
				header('Content-Length: ' . filesize($file));
				header('Content-Disposition: '.$mode.'; filename="'.$fileName.'"');
				readfile($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

			exit(0);
    	} else {
    		return view('404/component-view-404');
    	}
    }

    public function noImages() {
	  	$file = DIR_PUBLIC_ASSETS."/assets/system/img/image-broke.png";

  	 	try {
	      $mimes = mime_content_type($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }

	    try {
			$type = $mimes;
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($file));
			readfile($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }
		exit(0);
    }

    public function loaderImg() {
	  	$file = '';
	  	$fileName = '';

	  	if (isset($_GET['loader'])) {
	  		switch ($_GET['loader']) {
	  			case 'loader-image':
	  				$fileName = 'Spinner-1s-200px.svg';
  				break;
  				case 'loader-image-white':
	  				$fileName = 'Spinner-1s-200px-white.svg';
  				break;
  				case 'loader-image-data-table':
	  				$fileName = 'Infinity-1s-200px.svg';
  				break;
  				case 'loader-image-spinner':
	  				$fileName = 'Double-Ring-1s-131px.svg';
  				break;
  				case 'loader-shimmer':
	  				$fileName = '56113-lazy-load-shimmer.gif';
  				break;
	  		}

		  	$file = DIR_PUBLIC_ASSETS."/assets/system/loader/{$fileName}";
	  	} else {
	  		throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	  	}

  	 	try {
	      $mimes = mime_content_type($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }

	    try {
			$type = $mimes;
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($file));
			readfile($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }
		exit(0);
    }

    public function globalLoadFiles($files = '') {
    	$result = $this->classesModel->decrypter($files);
    	$resDecode = urldecode($result);
    	$path = site_url($resDecode);

    	$arr = explode('/', $resDecode); 
	    $fileName = $arr[count($arr)-1];

    	$str  = $resDecode;
	  	$file = DIR_PUBLIC_ASSETS."/{$str}";

	  	$mode = 'download'; // Default mode
	  	if (isset($_GET['mode'])) {
	  		$mode = ($_GET['mode'] == 'download') ? 'attachment' : 'inline';
	  	}

  	 	try {
	      $mimes = mime_content_type($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }

	    try {
			$type = $mimes;
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($file));
			header('Content-Disposition: '.$mode.'; filename="'.$fileName.'"');
			readfile($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }
		exit(0);
    }

    public function favicon() {
	  	$file = DIR_PUBLIC_ASSETS."/assets/system/img/favicon.png";

  	 	try {
	      $mimes = mime_content_type($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }

	    try {
			$type = $mimes;
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($file));
			readfile($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }
		exit(0);
    }

    public function logo() {
	  	$file = DIR_PUBLIC_ASSETS.'/assets/system/img/logo.png';

  	 	try {
	      $mimes = mime_content_type($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }

	    try {
			$type = $mimes;
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($file));
			readfile($file);
	    } catch (\Exception $e) {
	      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	    }
		exit(0);
    }

    public function Libs() {
    	if (isset($_GET['f'])) {
    		$params = rawurldecode(base64_decode($_GET['f']));
    		$file = DIR_PUBLIC_ASSETS."/{$params}";
	  	 	try {
		      $mimes = mime_content_type($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

		    try {
				$type = $mimes;
				header('Content-Type: text/javascript');
				header('Content-Length: ' . filesize($file));
				readfile($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }
			exit(0);
    	} else {
    		return view('404/component-view-404');
    	}
    }

    public function loadJs() {
    	if (isset($_GET['f'])) {
    		$params = rawurldecode($_GET['f']);
    		$file = DIR_PUBLIC_ASSETS."/assets/{$params}";
	  	 	try {
		      $mimes = mime_content_type($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

		    try {
				$type = $mimes;
				header('Content-Type: text/javascript');
				header('Content-Length: ' . filesize($file));
				readfile($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }
			exit(0);
    	} else {
    		return view('404/component-view-404');
    	}
    }

    public function loadCss() {
    	if (isset($_GET['f'])) {
    		$params = rawurldecode($_GET['f']);
    		$file = DIR_PUBLIC_ASSETS."/assets/{$params}";
			try {
		      $mimes = mime_content_type($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }

		    try {
				$type = $mimes;
				header('Content-Type: text/css');
				header('Content-Length: ' . filesize($file));
				readfile($file);
		    } catch (\Exception $e) {
		      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		    }
    	} else {
    		return view('404/component-view-404');
    	}
    }

    public function configLib() {
    	if (isset($_GET['f'])) {
    		if (date('Ymd', explode("~", base64_decode($_GET['f']))[1]) == date('Ymd')) {
		    	$actionPath = json_encode(json_decode(file_get_contents(ROOTPATH."/app/Config/Lib/".explode("~", base64_decode($_GET['f']))[0].".app.json"), true));
     			return $this->response->setJson($actionPath);
    		} else {
	    		return view('404/component-view-404');
	    	}
    	} else {
    		return view('404/component-view-404');
    	}
    }
}
