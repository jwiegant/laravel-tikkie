<?php

namespace Cloudmazing\Tikkie\Tests;

use Cloudmazing\Tikkie\Facades\Tikkie;
use Cloudmazing\Tikkie\Response\ApplicationResponse;
use Cloudmazing\Tikkie\Response\ErrorListResponse;
use Cloudmazing\Tikkie\Response\ErrorResponse;
use Cloudmazing\Tikkie\Response\PaymentListResponse;
use Cloudmazing\Tikkie\Response\PaymentRequestListResponse;
use Cloudmazing\Tikkie\Response\PaymentRequestResponse;
use Cloudmazing\Tikkie\Response\PaymentResponse;
use Cloudmazing\Tikkie\Response\RefundResponse;
use Cloudmazing\Tikkie\Response\SubscriptionDeleteResponse;
use Cloudmazing\Tikkie\Response\SubscriptionResponse;
use Cloudmazing\Tikkie\Tests\Helpers\Helper;
use Cloudmazing\Tikkie\Tests\Mocks\ApplicationResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\CreatePaymentRequestResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\CreateRefundResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\CreateSubscriptionResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\DeleteSubscriptionResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\ErrorResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\GetPaymentRequestsResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\GetPaymentResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\GetRefundResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\ListPaymentRequestsResponseMock;
use Cloudmazing\Tikkie\Tests\Mocks\ListPaymentsResponseMock;
use Cloudmazing\Tikkie\TikkieServiceProvider;
use Exception;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * This is the abstract test case class.
 *
 * @category Tests
 * @author  Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class TestCase extends OrchestraTestCase
{
    /**
     * @var Helper Helper variable
     */
    private $helper;

    /**
     * Set up the environment.
     *
     * @param  Application  $app
     *
     * @throws Exception
     */
    protected function getEnvironmentSetUp($app)
    {
        // Get the helper
        $helper = $this->getHelper();

        // Fill the config
        config(['tikkie.api-key' => $helper->getRandomString(10)]);
        config(['tikkie.sandbox' => 'true']);
        config(['tikkie.app-token' => $this->createTikkieApplication()]);
    }

    /**
     * Get the service provider class.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [TikkieServiceProvider::class];
    }

    /**
     * Get the helper class.
     *
     * @return Helper
     */
    private function getHelper()
    {
        // Check if we already created the helper
        if ($this->helper === null) {
            // Create the helper if it doesn't exist
            $this->helper = new Helper();
        }

        // Return the helper
        return $this->helper;
    }

    /**
     * Get the facade class.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Tikkie' => Tikkie::class,
        ];
    }

    /**
     * Creation of a Tikkie application.
     *
     * @return string
     * @throws Exception
     */
    public function createTikkieApplication()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Variables
        $appToken = $helper->getRandomString(20);

        // Set the Application Response Mock
        new ApplicationResponseMock($appToken);

        // Create the application request
        $applicationRequest = new \Cloudmazing\Tikkie\Request\Application();

        // Create the application call class
        $createApplication = new \Cloudmazing\Tikkie\Application();

        /**
         * Create the application.
         *
         * @var ApplicationResponse $applicationResponse
         */
        $applicationResponse = $createApplication->create(
            $applicationRequest
        );

        // Response must be an instance of ApplicationResponse
        $this->assertInstanceOf(ApplicationResponse::class, $applicationResponse);

        // appToken must be filled
        $this->assertEquals(
            $appToken,
            $applicationResponse->getAppToken(),
            'AppToken should be equal.'
        );

        // Return the app token to be used in other test cases
        return $applicationResponse->getAppToken();
    }

    /**
     * Set and return the tikkie object.
     *
     * @return \Cloudmazing\Tikkie\Tikkie
     */
    private function getTikke()
    {
        /** @var \Cloudmazing\Tikkie\Tikkie $tikkie */
        $tikkie = app('tikkie');

        // Set the configuration
        $tikkie->setConfiguration(
            config('tikkie.api-key'),
            config('tikkie.app-token'),
            config('tikkie.sandbox')
        );

        // Return the tikkie instance
        return $tikkie;
    }

    /**
     * Test the create payment request.
     *
     * @throws Exception
     */
    public function testCreatePaymentRequest()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Variables
        $paymentRequestToken = $helper->getRandomString(20);
        $url = $helper->getRandomUrl();
        $createdDateTime = $helper->getCarbonDate();
        $status = PaymentRequestResponse::OPEN;
        $description = $helper->getRandomString(20);
        $amount = $helper->getRandomNumber(5) / 100;
        ;
        $referenceId = $helper->getRandomString(20);
        $expiryDate = $helper->getRandomFutureCarbonDate()
                             ->setTime(0, 0, 0, 0);

        // Set the mock response
        new CreatePaymentRequestResponseMock(
            $paymentRequestToken,
            $amount,
            $referenceId,
            $description,
            $url,
            $expiryDate,
            $createdDateTime,
            $status
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var PaymentRequestResponse $payment
         */
        $payment = $tikkie->paymentRequest()
                          ->create(
                              $description,
                              $amount,
                              $referenceId,
                              $expiryDate
                          );

        // Asserts
        $this->assertInstanceOf(
            PaymentRequestResponse::class,
            $payment
        );

        $this->assertEquals(
            $paymentRequestToken,
            $payment->getPaymentRequestToken()
        );

        $this->assertEquals(
            $url,
            $payment->getUrl()
        );

        $this->assertEquals(
            $createdDateTime,
            $payment->getCreatedDateTime()
        );

        $this->assertTrue(
            $payment->isOpen()
        );

        $this->assertEquals(
            $description,
            $payment->getDescription()
        );

        $this->assertEquals(
            (int) ($amount * 100),
            $payment->getAmountInCents()
        );

        $this->assertEquals(
            $referenceId,
            $payment->getReferenceId()
        );

        $this->assertEquals(
            $expiryDate,
            $payment->getExpiryDate()
        );
    }

    /**
     * Test the list of payment requests.
     *
     * @throws Exception
     */
    public function testListPaymentRequest()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Variables
        $totalElementCount = 2;
        $paymentRequestToken1 = $helper->getRandomString(20);
        $amount1 = $helper->getRandomNumber(5) / 100;
        $referenceId1 = $helper->getRandomString(20);
        $description1 = $helper->getRandomString(20);
        $url1 = $helper->getRandomUrl();
        $expiryDate1 = $helper->getRandomFutureCarbonDate()
                              ->setTime(0, 0, 0, 0);
        $createdDateTime1 = $helper->getCarbonDate();
        $status1 = PaymentRequestResponse::OPEN;
        $numberOfPayments1 = $helper->getRandomNumber(1);
        $totalAmountPaidInCents1 = $helper->getRandomNumber(4);
        $paymentRequestToken2 = $helper->getRandomString(20);
        $amount2 = $helper->getRandomNumber(5) / 100;
        $referenceId2 = $helper->getRandomString(20);
        $description2 = $helper->getRandomString(20);
        $url2 = $helper->getRandomUrl();
        $expiryDate2 = $helper->getRandomFutureCarbonDate()
                              ->setTime(0, 0, 0, 0);
        $createdDateTime2 = $helper->getCarbonDate();
        $status2 = PaymentRequestResponse::CLOSED;
        $numberOfPayments2 = $helper->getRandomNumber(2);
        $totalAmountPaidInCents2 = $helper->getRandomNumber(4);

        // Set the mock response
        new ListPaymentRequestsResponseMock(
            $totalElementCount,
            $paymentRequestToken1,
            $amount1,
            $referenceId1,
            $description1,
            $url1,
            $expiryDate1,
            $createdDateTime1,
            $status1,
            $numberOfPayments1,
            $totalAmountPaidInCents1,
            $paymentRequestToken2,
            $amount2,
            $referenceId2,
            $description2,
            $url2,
            $expiryDate2,
            $createdDateTime2,
            $status2,
            $numberOfPayments2,
            $totalAmountPaidInCents2
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var PaymentRequestListResponse $paymentRequestListResponse
         */
        $paymentRequestListResponse = $tikkie->paymentRequest()
                                             ->list();

        $this->assertInstanceOf(
            PaymentRequestListResponse::class,
            $paymentRequestListResponse
        );

        $this->assertEquals(
            $totalElementCount,
            $paymentRequestListResponse->getTotalElementCount()
        );

        $payment = $paymentRequestListResponse->getPaymentRequests()
                                              ->first();

        $this->assertEquals(
            $paymentRequestToken1,
            $payment->getPaymentRequestToken()
        );

        $this->assertEquals(
            (int) ($amount1 * 100),
            $payment->getAmountInCents()
        );

        $this->assertEquals(
            $referenceId1,
            $payment->getReferenceId()
        );

        $this->assertEquals(
            $description1,
            $payment->getDescription()
        );

        $this->assertEquals(
            $url1,
            $payment->getUrl()
        );

        $this->assertEquals(
            $expiryDate1,
            $payment->getExpiryDate()
        );

        $this->assertEquals(
            $createdDateTime1,
            $payment->getCreatedDateTime()
        );

        $this->assertEquals(
            $status1,
            $payment->getStatus()
        );

        $this->assertEquals(
            $numberOfPayments1,
            $payment->getNumberOfPayments()
        );

        $this->assertEquals(
            $totalAmountPaidInCents1,
            $payment->getTotalAmountPaidInCents()
        );

        $this->assertTrue(
            $payment->isOpen()
        );

        $payment = $paymentRequestListResponse->getPaymentRequests()
                                              ->last();

        $this->assertEquals(
            $paymentRequestToken2,
            $payment->getPaymentRequestToken()
        );

        $this->assertEquals(
            (int) ($amount2 * 100),
            $payment->getAmountInCents()
        );

        $this->assertEquals(
            $referenceId2,
            $payment->getReferenceId()
        );

        $this->assertEquals(
            $description2,
            $payment->getDescription()
        );

        $this->assertEquals(
            $url2,
            $payment->getUrl()
        );

        $this->assertEquals(
            $expiryDate2,
            $payment->getExpiryDate()
        );

        $this->assertEquals(
            $createdDateTime2,
            $payment->getCreatedDateTime()
        );

        $this->assertEquals(
            $status2,
            $payment->getStatus()
        );

        $this->assertEquals(
            $numberOfPayments2,
            $payment->getNumberOfPayments()
        );

        $this->assertEquals(
            $totalAmountPaidInCents2,
            $payment->getTotalAmountPaidInCents()
        );

        $this->assertTrue(
            ! $payment->isOpen()
        );
    }

    /**
     * Test get payment request.
     *
     * @throws Exception
     */
    public function testGetPaymentRequest()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Variables
        $paymentRequestToken = $helper->getRandomString(20);
        $amount = $helper->getRandomNumber(5) / 100;
        $referenceId = $helper->getRandomString(20);
        $description = $helper->getRandomString(20);
        $url = $helper->getRandomUrl();
        $expiryDate = $helper->getRandomFutureCarbonDate()
                             ->setTime(0, 0, 0, 0);
        $createdDateTime = $helper->getCarbonDate();
        $status = PaymentRequestResponse::OPEN;
        $numberOfPayments = $helper->getRandomNumber(1);
        $totalAmountPaidInCents = $helper->getRandomNumber(4);

        // Set the mock response
        new GetPaymentRequestsResponseMock(
            $paymentRequestToken,
            $amount,
            $referenceId,
            $description,
            $url,
            $expiryDate,
            $createdDateTime,
            $status,
            $numberOfPayments,
            $totalAmountPaidInCents
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var PaymentRequestResponse $payment
         */
        $payment = $tikkie->paymentRequest()
                          ->get('PAYMENT_REQUEST_TOKEN');

        // Asserts
        $this->assertInstanceOf(
            PaymentRequestResponse::class,
            $payment
        );

        $this->assertEquals(
            $paymentRequestToken,
            $payment->getPaymentRequestToken()
        );

        $this->assertEquals(
            (int) ($amount * 100),
            $payment->getAmountInCents()
        );

        $this->assertEquals(
            $referenceId,
            $payment->getReferenceId()
        );

        $this->assertEquals(
            $description,
            $payment->getDescription()
        );

        $this->assertEquals(
            $url,
            $payment->getUrl()
        );

        $this->assertEquals(
            $expiryDate,
            $payment->getExpiryDate()
        );

        $this->assertEquals(
            $createdDateTime,
            $payment->getCreatedDateTime()
        );

        $this->assertEquals(
            $status,
            $payment->getStatus()
        );

        $this->assertEquals(
            $numberOfPayments,
            $payment->getNumberOfPayments()
        );

        $this->assertEquals(
            $totalAmountPaidInCents,
            $payment->getTotalAmountPaidInCents()
        );

        $this->assertTrue(
            $payment->isOpen()
        );
    }

    /**
     * Test the error response.
     *
     * @throws Exception
     */
    public function testErrorResponse()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Variables
        $code = ErrorResponse::DESCRIPTION_MISSING;
        $message = $helper->getRandomString(20);
        $reference = $helper->getRandomString(20);
        $traceId = $helper->getRandomString(20);
        $status = 400;

        // Set the mock response
        new ErrorResponseMock($code, $message, $reference, $traceId, $status);

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        // Get the error
        $errorListResponse = $tikkie->paymentRequest()
                                    ->get('PAYMENT_REQUEST_TOKEN');

        // Asserts
        $this->assertInstanceOf(
            ErrorListResponse::class,
            $errorListResponse
        );

        /**
         * @var ErrorResponse $errorResponse
         */
        $errorResponse = $errorListResponse->getErrors()
                                           ->first();
        $this->assertInstanceOf(
            ErrorResponse::class,
            $errorResponse
        );

        $this->assertEquals(
            $code,
            $errorResponse->getCode()
        );

        $this->assertEquals(
            $message,
            $errorResponse->getMessage()
        );

        $this->assertEquals(
            $reference,
            $errorResponse->getReference()
        );

        $this->assertEquals(
            $traceId,
            $errorResponse->getTraceId()
        );

        $this->assertEquals(
            $status,
            $errorResponse->getStatus()
        );
    }

    /**
     * Test the list of payments.
     *
     * @throws Exception
     */
    public function testListPayment()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Variables
        $totalElementCount = 1;
        $paymentToken = $helper->getRandomString(20);
        $tikkieId = $helper->getRandomNumber(10);
        $counterPartyName = $helper->getRandomString(20);
        $counterPartyAccountNumber = $helper->getRandomString(20);
        $amount = $helper->getRandomNumber(5) / 100;
        $description = $helper->getRandomString(20);
        $createdDateTime = $helper->getCarbonDate();
        $refundToken = $helper->getRandomString(20);
        $refundAmount = $helper->getRandomNumber(4) / 100;
        $refundDescription = $helper->getRandomString(20);
        $refundReferenceId = $helper->getRandomString(20);
        $refundCreatedDateTime = $helper->getRandomFutureCarbonDate();
        $refundStatus = RefundResponse::STATUS_PENDING;

        // Set the mock response
        new ListPaymentsResponseMock(
            $totalElementCount,
            $paymentToken,
            $tikkieId,
            $counterPartyName,
            $counterPartyAccountNumber,
            $amount,
            $description,
            $createdDateTime,
            $refundToken,
            $refundAmount,
            $refundDescription,
            $refundReferenceId,
            $refundCreatedDateTime,
            $refundStatus
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var PaymentListResponse $payment
         */
        $payments = $tikkie->payment()
                           ->list('PAYMENT-REQUEST-TOKEN');

        $this->assertInstanceOf(
            PaymentListResponse::class,
            $payments
        );

        $this->assertEquals(
            $totalElementCount,
            $payments->getTotalElementCount()
        );

        /** @var PaymentResponse $payment */
        $payment = $payments->getPayments()
                            ->first();

        $this->assertEquals(
            $paymentToken,
            $payment->getPaymentToken()
        );

        $this->assertEquals(
            $tikkieId,
            $payment->getTikkieId()
        );

        $this->assertEquals(
            $counterPartyName,
            $payment->getCounterPartyName()
        );

        $this->assertEquals(
            $counterPartyAccountNumber,
            $payment->getCounterPartyAccountNumber()
        );

        $this->assertEquals(
            (int) ($amount * 100),
            $payment->getAmountInCents()
        );

        $this->assertEquals(
            $description,
            $payment->getDescription()
        );

        $this->assertEquals(
            $createdDateTime,
            $payment->getCreatedDateTime()
        );

        /** @var RefundResponse $refund */
        $refund = $payment->getRefunds()
                          ->first();

        $this->assertEquals(
            $refundToken,
            $refund->getRefundToken()
        );

        $this->assertEquals(
            (int) ($refundAmount * 100),
            $refund->getAmountInCents()
        );

        $this->assertEquals(
            $refundDescription,
            $refund->getDescription()
        );

        $this->assertEquals(
            $refundReferenceId,
            $refund->getReferenceId()
        );

        $this->assertEquals(
            $refundCreatedDateTime,
            $refund->getCreatedDateTime()
        );

        $this->assertEquals(
            $refundStatus,
            $refund->getStatus()
        );
    }

    /**
     * Test get the payment.
     *
     * @throws Exception
     */
    public function testGetPayment()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Variables
        $paymentToken = $helper->getRandomString(20);
        $tikkieId = $helper->getRandomNumber(10);
        $counterPartyName = $helper->getRandomString(20);
        $counterPartyAccountNumber = $helper->getRandomString(20);
        $amount = $helper->getRandomNumber(5) / 100;
        ;
        $description = $helper->getRandomString(20);
        $createdDateTime = $helper->getCarbonDate();
        $refundToken = $helper->getRandomString(20);
        $refundAmount = $helper->getRandomNumber(5) / 100;
        ;
        $refundDescription = $helper->getRandomString(20);
        $refundReferenceId = $helper->getRandomString(20);
        $refundCreatedDateTime = $helper->getRandomFutureCarbonDate();
        $refundStatus = RefundResponse::STATUS_PENDING;

        // Set the mock response
        new GetPaymentResponseMock(
            $paymentToken,
            $tikkieId,
            $counterPartyName,
            $counterPartyAccountNumber,
            $amount,
            $description,
            $createdDateTime,
            $refundToken,
            $refundAmount,
            $refundDescription,
            $refundReferenceId,
            $refundCreatedDateTime,
            $refundStatus
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var PaymentResponse $paymentResponse
         */
        $paymentResponse = $tikkie->payment()
                                  ->get(
                                      'PAYMENT-REQUEST-TOKEN',
                                      'PAYMENT-TOKEN'
                                  );

        /**
         * Asserts.
         */
        $this->assertInstanceOf(
            PaymentResponse::class,
            $paymentResponse
        );

        $this->assertEquals(
            $paymentToken,
            $paymentResponse->getPaymentToken()
        );

        $this->assertEquals(
            $tikkieId,
            $paymentResponse->getTikkieId()
        );

        $this->assertEquals(
            $counterPartyName,
            $paymentResponse->getCounterPartyName()
        );

        $this->assertEquals(
            $counterPartyAccountNumber,
            $paymentResponse->getCounterPartyAccountNumber()
        );

        $this->assertEquals(
            (int) ($amount * 100),
            $paymentResponse->getAmountInCents()
        );

        $this->assertEquals(
            $description,
            $paymentResponse->getDescription()
        );

        $this->assertEquals(
            $createdDateTime,
            $paymentResponse->getCreatedDateTime()
        );

        /** @var RefundResponse $refund */
        $refund = $paymentResponse->getRefunds()
                                  ->first();

        $this->assertEquals(
            $refundToken,
            $refund->getRefundToken()
        );

        $this->assertEquals(
            (int) ($refundAmount * 100),
            $refund->getAmountInCents()
        );

        $this->assertEquals(
            $refundDescription,
            $refund->getDescription()
        );

        $this->assertEquals(
            $refundReferenceId,
            $refund->getReferenceId()
        );

        $this->assertEquals(
            $refundCreatedDateTime,
            $refund->getCreatedDateTime()
        );

        $this->assertEquals(
            $refundStatus,
            $refund->getStatus()
        );
    }

    /**
     * Test a refund creation.
     *
     * @throws Exception
     */
    public function testCreateRefund()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Input data
        $refundToken = $helper->getRandomString(20);
        $amount = $helper->getRandomNumber(5) / 100;
        ;
        $description = $helper->getRandomString(20);
        $referenceId = $helper->getRandomString(20);
        $createdDateTime = $helper->getCarbonDate();
        $status = RefundResponse::STATUS_PAID;
        $paymentRequestToken = $helper->getRandomString(20);
        $paymentToken = $helper->getRandomString(20);

        // Set the mock response
        new CreateRefundResponseMock(
            $refundToken,
            $amount,
            $description,
            $referenceId,
            $createdDateTime,
            $status
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var RefundResponse $refundResponse
         */
        $refundResponse = $tikkie->refund()
                                 ->create(
                                     $paymentRequestToken,
                                     $paymentToken,
                                     $description,
                                     $amount,
                                     $referenceId
                                 );

        // Asserts
        $this->assertInstanceOf(
            RefundResponse::class,
            $refundResponse
        );

        $this->assertEquals(
            $refundToken,
            $refundResponse->getRefundToken()
        );

        $this->assertEquals(
            (int) ($amount * 100),
            $refundResponse->getAmountInCents()
        );

        $this->assertEquals(
            $description,
            $refundResponse->getDescription()
        );

        $this->assertEquals(
            $referenceId,
            $refundResponse->getReferenceId()
        );

        $this->assertEquals(
            $createdDateTime,
            $refundResponse->getCreatedDateTime()
        );

        $this->assertEquals(
            $status,
            $refundResponse->getStatus()
        );

        $this->assertTrue(
            ($status === RefundResponse::STATUS_PAID) ? $refundResponse->isPaid(
            ) : ! $refundResponse->isPaid()
        );
    }

    /**
     * Test get the refund.
     *
     * @throws Exception
     */
    public function testGetRefund()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Variables
        $paymentRequestToken = $helper->getRandomString(20);
        $paymentToken = $helper->getRandomString(20);
        $refundToken = $helper->getRandomString(20);
        $amount = $helper->getRandomNumber(5) / 100;
        $description = $helper->getRandomString(20);
        $referenceId = $helper->getRandomString(20);
        $createdDateTime = $helper->getRandomFutureCarbonDate();
        $status = RefundResponse::STATUS_PAID;

        // Set the mock response
        new GetRefundResponseMock(
            $refundToken,
            $amount,
            $description,
            $referenceId,
            $createdDateTime,
            $status
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var RefundResponse $refundResponse
         */
        $refundResponse = $tikkie->refund()
                                 ->get(
                                     $paymentRequestToken,
                                     $paymentToken,
                                     $refundToken
                                 );

        /**
         * Asserts.
         */
        $this->assertInstanceOf(
            RefundResponse::class,
            $refundResponse
        );

        $this->assertEquals(
            $refundToken,
            $refundResponse->getRefundToken()
        );

        $this->assertEquals(
            (int) ($amount * 100),
            $refundResponse->getAmountInCents()
        );

        $this->assertEquals(
            $description,
            $refundResponse->getDescription()
        );

        $this->assertEquals(
            $referenceId,
            $refundResponse->getReferenceId()
        );

        $this->assertEquals(
            $createdDateTime,
            $refundResponse->getCreatedDateTime()
        );

        $this->assertEquals(
            $status,
            $refundResponse->getStatus()
        );

        $this->assertTrue(
            ($status === RefundResponse::STATUS_PAID ? $refundResponse->isPaid(
            ) : ! $refundResponse->isPaid())
        );
    }

    /**
     * Test a subscription creation.
     *
     * @throws Exception
     */
    public function testCreateSubscription()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Input data
        $subscriptionId = $helper->getRandomString(20);

        // Set the mock response
        new CreateSubscriptionResponseMock(
            $subscriptionId
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var SubscriptionResponse $subscriptionResponse
         */
        $subscriptionResponse = $tikkie->subscription()
                                       ->create(
                                           $subscriptionId
                                       );

        // Asserts
        $this->assertInstanceOf(
            SubscriptionResponse::class,
            $subscriptionResponse
        );

        $this->assertEquals(
            $subscriptionId,
            $subscriptionResponse->getSubscriptionId()
        );
    }

    /**
     * Test a subscription deletion.
     *
     * @throws Exception
     */
    public function testDeleteSubscription()
    {
        // Get the helper
        $helper = $this->getHelper();

        // Input data
        $traceId = $helper->getRandomString(20);

        // Set the mock response
        new DeleteSubscriptionResponseMock(
            $traceId
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var SubscriptionDeleteResponse $subscriptionResponse
         */
        $subscriptionResponse = $tikkie->subscription()
                                       ->delete();

        // Asserts
        $this->assertInstanceOf(
            SubscriptionDeleteResponse::class,
            $subscriptionResponse
        );
    }
}
