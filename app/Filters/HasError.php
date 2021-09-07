<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class HasError implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if($session!=null){
            if (! $session->isLoggedIn)
            {
                //$session->has_error=true;
                return redirect('/');
            }
            else{
                if(! $session->has_error){
                    $url=base_url();
                    return redirect($url);
                }
            }
        }

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}