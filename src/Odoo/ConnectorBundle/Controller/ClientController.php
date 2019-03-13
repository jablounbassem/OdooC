<?php

namespace Odoo\ConnectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Odoo\ConnectorBundle\Entity\Client;
use Odoo\ConnectorBundle\Form\ClientType;
use Odoo\ConnectorBundle\Traits\ripcord;

class ClientController extends Controller
{
    public function indexAction()
    {

        $client= new Client();
       // $form=$this->createForm(ClientType::class,$client);
        $form=$this->createForm(ClientType::class,$client);
        return $this->render('@OdooConnector/Client/add.html.twig',array(
        'form'=>$form->createView()

        ) );
    }


    public function addAction($name)
    {
        //
        $tab=array(
            'name'=>"$name",
            'country_id'=>1
        );

        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //print_r($common->version());
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());
        $id = $models->execute_kw($db, $uid, $password,
            'res.partner', 'create',
            array($tab));
        //   echo $id;
        return $this->render('OdooConnectorBundle:Users:add.html.twig');
    }

    public function listUsersAction(){
        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;


        $common = ripcord::client($url.'/xmlrpc/2/common');
        $uid = $common->authenticate($db, $username, $password, array());
        $models = ripcord::client("$url/xmlrpc/2/object");

        $partners= $models->execute_kw($db, $uid, $password,
            'res.partner', 'search_read',
            array(array(
            )),
            array('fields'=>array('name', 'country_id', 'comment')));
        return $this->render('OdooConnectorBundle:Users:list.html.twig',array(
           'partners'=>$partners));

    }

    public function updateAction($id,$name){
        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //print_r($common->version());
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());
        $models->execute_kw($db, $uid, $password, 'res.partner', 'write',
            array(array((int)$id), array('name'=>"$name")));
        return $this->forward('OdooConnectorBundle:Default:listUsers');

    }
    public function deleteAction($id){
        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());
        $models->execute_kw($db, $uid, $password,
            'res.partner', 'unlink',
            array(array((int)$id)));

        $this->container->getParameter("url_odoo");
        return $this->forward('OdooConnectorBundle:Default:listUsers');

    }

    public function qdqsdAction()
    {
        
    }

}
