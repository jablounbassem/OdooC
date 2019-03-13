<?php

namespace Odoo\ConnectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Odoo\ConnectorBundle\Traits\ripcord;
use Odoo\ConnectorBundle\Entity\Commande;
use Odoo\ConnectorBundle\Form\CommandeType;
use Symfony\Component\HttpFoundation\Request;

class CommandeController extends Controller
{
    public function indexAction()
    {


        return $this->render('OdooConnectorBundle:Default:index.html.twig');
    }

    public function showFormAction()
    {

        $commande= new Commande();
        $form=$this->createForm(CommandeType::class,$commande,array(
            'action'=>$this->generateUrl('odoo_connector_addCommande')
        ));
        return $this->render('@OdooConnector/Commande/add.html.twig',array(
            'form'=>$form->createView()

        ) );
    }


    public function addAction(Request $request)
    {
        $commande=new Commande();
        $form=$this->createForm(CommandeType::class,$commande );
        $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid())
    {
        //$em = $this->getDoctrine()->getManager();
       // $em->persist($commande);

        echo $commande->getName();

    }else{
        return $this->forward('OdooConnectorBundle:Commande:index');
    }
        //return $this->render('OdooConnectorBundle:Default:index.html.twig');

    }

    public function oddAddAction()
    {

        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //print_r($common->version());
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());



        $commande = $models->execute_kw($db, $uid, $password,
            'purchase.orde', 'create',
            array(array(
                'name'=>"PO00008",
                'partner_id' =>12
              ,
                'company_id' =>1
                     ,
                'currency_id' =>133
                    ,
                'date_order' => '2019-02-25 10:40:17',
            )));



        //$dumper->dump($cloner->cloneVar($partners));

        // echo var_dump($partners);
        die("bonjour");
        return $this->render('OdooConnectorBundle:Default:index.html.twig');
    }

    public function testAction()
    {
        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //print_r($common->version());
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());
      //  $partners= $models->execute_kw($db, $uid, $password,
        //    'purchase.order.line', 'fields_get',
          //  array());
        $tab=array(
            'company_id'=>1,
            'currency_id'=>1,
            'partner_id'=>1


        );
       $id = $models->execute_kw($db, $uid, $password,
            'purchase.order', 'create',
            array($tab));

        // echo var_dump($partners);

       // $partners[0]['name']='PO00008';
        echo '<pre>' . var_export($id, true) . '</pre>';
       // $id = $models->execute_kw($db, $uid, $password,
         //   'purchase.order', 'create',
           // array($partners));
        die("");
        return $this->render('OdooConnectorBundle:Default:index.html.twig');
        
    }


    public function testLigneCommandeAction(){

        $url  =  "http://192.168.99.100:8069" ;
        $db  =  "sofia";
        $username = "jablounbassem.tn@gmail.com" ;
        $password = "sofiaholding" ;
        $common = ripcord::client($url.'/xmlrpc/2/common');
        //print_r($common->version());
        $models = ripcord::client("$url/xmlrpc/2/object");
        $uid = $common->authenticate($db, $username, $password, array());

        $tab=array(
            'name'=>"description",
            'date_planned'=>'2019-03-25 10:40:17',
            'product_qty'=>20,
            'product_uom'=>2,
            'product_id'=>1,
            'price_unit'=>1000,
            'order_id'=>9,
        );

        $partners=$models->execute_kw($db, $uid, $password,
            'purchase.order.line', 'create',
            array($tab));

        echo '<pre>' . var_export($partners, true) . '</pre>';

        die('bonjour');
        return "";
    }



}
