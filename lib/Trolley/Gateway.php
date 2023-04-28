<?php
namespace Trolley;

/**
 * Trolley gateway module
 *
 * @package    Trolley
 * @category   Resources
 */
class Gateway
{
    /**
     *
     * @var Configuration
     */
    public $config;
    public function __construct($config)
    {
        if (is_array($config)) {
            $config = new Configuration($config);
        }
        $this->config = $config;
    }

    /**
     * @return RecipientGateway
     */
    public function recipient()
    {
        return new RecipientGateway($this);
    }

    /**
     * @return RecipientAccountGateway
     */
    public function recipientAccount()
    {
        return new RecipientAccountGateway($this);
    }

    /**
     * @return BatchGateway
     */
    public function batch()
    {
        return new BatchGateway($this);
    }

    /**
     * @return PaymentGateway
     */
    public function payments()
    {
        return new PaymentGateway($this);
    }

    /**
     * @return OfflinePaymentGateway
     */
    public function offlinePayments()
    {
        return new OfflinePaymentGateway($this);
    }

    /**
     * @return InvoiceGateway
     */
    public function invoice()
    {
        return new InvoiceGateway($this);
    }

    /**
     * @return InvoiceLineGateway
     */
    public function invoiceLine()
    {
        return new InvoiceLineGateway($this);
    }

    /**
     * @return InvoicePaymentGateway
     */
    public function invoicePayment()
    {
        return new InvoicePaymentGateway($this);
        
    }

    /**
     * @return BalanceGateway
     */
    public function balance()
    {
        return new BalanceGateway($this);
    }
}

class_alias('Trolley\Gateway', 'Trolley_Gateway');
