<?php

namespace Odoo\ConnectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Odoo\ConnectorBundle\Traits\ripcord;
use Symfony\Component\HttpFoundation\Request;

class PurchaseController extends Controller
{
    public function indexAction()
    {
        return $this->render('OdooConnectorBundle::index.html.twig');
    }

    public function listPurchaseAction()
    {
        $service = $this->get('OdooService');
        $purchases = $service->search('purchase.order');
        return $this->render('OdooConnectorBundle:Purchase:add.html.twig', array(
            "purchases" => $purchases
        ));
    }


    public function addPurchaseFormAction()
    {

        $service = $this->get('OdooService');
        $option[0] = array('supplier', '=', true);
        $vendor = $service->search('res.partner', $option);
        return $this->render('OdooConnectorBundle:Purchase:purchase_add.html.twig', array("vendors" => $vendor));

    }

    public function addPurcheseAction(Request $request)
    {
        $service = $this->get('OdooService');
        $idVendor = (int)$_POST['vendor'];
        $vendor = $service->search('res.partner');
        $purchase = array(
            'company_id' => $vendor[0]['company_id'][0],
            'currency_id' => $vendor[0]['currency_id'][0],
            'partner_id' => $idVendor

        );
        $service->create('purchase.order', $purchase);
        return $this->forward('OdooConnectorBundle:Purchase:listPurchase');

    }
    
    public function commandeLineFormAction()
    {

        $service = $this->get('OdooService');
        $orders = $service->search('purchase.order');
        $articles = $service->search('product.template');
        return $this->render("@OdooConnector/Commande/add.html.twig", array(
            'orders' => $orders,
            'articles' => $articles
        ));
    }

    public function commandeLineAddAction()
    {
        $service = $this->get('OdooService');
        $date = $_POST["date"] . " 00:00:00";
        $commandeline = array(
            'name' => $_POST["decription"],
            'date_planned' => $date,
            'product_qty' => $_POST["quantite"],
            'product_id' => $_POST["article"],
            'order_id' => $_POST["commande"],
            'price_unit' => $_POST["pu"],
            'product_uom' => 2,
        );
        $service->create('purchase.order.line', $commandeline);
        return $this->forward('OdooConnectorBundle:Purchase:listPurchase');
    }

    public function formAction()
    {
        return $this->render('@OdooConnector/Purchase/add.html.twig');
    }
}
