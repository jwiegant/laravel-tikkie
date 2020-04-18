<?php

namespace Cloudmazing\Tikkie\Tests;


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
use Exception;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Cloudmazing\Tikkie\Facades\Tikkie;
use Cloudmazing\Tikkie\TikkieServiceProvider;

/**
 * This is the abstract test case class.
 *
 * @category Tests
 * @package Cloudmazing\Tikkie\Tests
 * @author  Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class TestCase extends OrchestraTestCase
{
    /**
     * Constants
     */
    /**
     * Invalid token
     */
    const INVALID_TOKEN = 'INVALID TOKEN';

    /**
     * Set up the environment.
     *
     * @param Application $app
     * @throws Exception
     */
    protected function getEnvironmentSetUp($app)
    {
        config(['tikkie.api-key' => Helper::getRandomString(10)]);
        config(['tikkie.sandbox' => 'true']);
        config(['tikkie.app-token' => $this->createTikkieApplication()]);
    }

    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [TikkieServiceProvider::class];
    }

    /**
     * Get the facade class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
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
     * Creation of a Tikkie application
     *
     * @return string
     * @throws Exception
     */
    public function createTikkieApplication()
    {
        // Variables
        $appToken = Helper::getRandomString(20);

        // Set the Application Response Mock
        new ApplicationResponseMock($appToken);

        // Create the application request
        $applicationRequest = new \Cloudmazing\Tikkie\Request\Application();

        // Create the application call class
        $createApplication = new \Cloudmazing\Tikkie\Application();

        /**
         * Create the application
         *
         * @var ApplicationResponse $applicationResponse
         */
        $applicationResponse = $createApplication->create(
            $applicationRequest
        );

        // Response must be an instance of ApplicationResponse
        $this->assertInstanceOf(ApplicationResponse::class, $applicationResponse);

        // appToken must be filled
        $this->assertEquals($appToken, $applicationResponse->getAppToken(), 'AppToken should be equal.');

        // Return the app token to be used in other test cases
        return $applicationResponse->getAppToken();
    }

    /**
     * Set and return the tikkie object
     *
     * @return \Cloudmazing\Tikkie\Tikkie
     */
    private function getTikke()
    {
        /** @var \Cloudmazing\Tikkie\Tikkie $tikkie */
        $tikkie = app('tikkie');
        $tikkie->setConfiguration(config('tikkie.api-key'), config('tikkie.app-token'), config('tikkie.sandbox'));

        // Return the tikkie instance
        return $tikkie;
    }

    /**
     * Test the create payment request
     *
     * @throws Exception
     */
    public function testCreatePaymentRequest()
    {
        // Variables
        $paymentRequestToken = Helper::getRandomString(20);
        $url = Helper::getRandomUrl();
        $createdDateTime = Helper::getCarbonDate();
        $status = PaymentRequestResponse::OPEN;
        $description = Helper::getRandomString(20);
        $amountInCents = Helper::getRandomNumber(4);
        $referenceId = Helper::getRandomString(20);
        $expiryDate = Helper::getRandomFutureCarbonDate()->setTime(0, 0, 0, 0);

        // Set the mock response
        new CreatePaymentRequestResponseMock($paymentRequestToken, $amountInCents, $referenceId, $description, $url,
            $expiryDate, $createdDateTime, $status);

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var PaymentRequestResponse $payment
         */
        $payment = $tikkie->createPaymentRequest($description, $amountInCents, $referenceId,
            $expiryDate);

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
            $amountInCents,
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
     * Test the list of payment requests
     *
     * @throws Exception
     */
    public function testListPaymentRequest()
    {
        // Variables
        $totalElementCount = 2;
        $paymentRequestToken1 = Helper::getRandomString(20);
        $amountInCents1 = Helper::getRandomNumber(4);
        $referenceId1 = Helper::getRandomString(20);
        $description1 = Helper::getRandomString(20);
        $url1 = Helper::getRandomUrl();
        $expiryDate1 = Helper::getRandomFutureCarbonDate()->setTime(0, 0, 0, 0);
        $createdDateTime1 = Helper::getCarbonDate();
        $status1 = PaymentRequestResponse::OPEN;
        $numberOfPayments1 = Helper::getRandomNumber(1);
        $totalAmountPaidInCents1 = Helper::getRandomNumber(4);
        $paymentRequestToken2 = Helper::getRandomString(20);
        $amountInCents2 = Helper::getRandomNumber(4);
        $referenceId2 = Helper::getRandomString(20);
        $description2 = Helper::getRandomString(20);
        $url2 = Helper::getRandomUrl();
        $expiryDate2 = Helper::getRandomFutureCarbonDate()->setTime(0, 0, 0, 0);
        $createdDateTime2 = Helper::getCarbonDate();
        $status2 = PaymentRequestResponse::CLOSED;
        $numberOfPayments2 = Helper::getRandomNumber(2);
        $totalAmountPaidInCents2 = Helper::getRandomNumber(4);

        // Set the mock response
        new ListPaymentRequestsResponseMock(
            $totalElementCount,
            $paymentRequestToken1,
            $amountInCents1,
            $referenceId1,
            $description1,
            $url1,
            $expiryDate1,
            $createdDateTime1,
            $status1,
            $numberOfPayments1,
            $totalAmountPaidInCents1,
            $paymentRequestToken2,
            $amountInCents2,
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
        $paymentRequestListResponse = $tikkie->listPaymentRequests();

        $this->assertInstanceOf(
            PaymentRequestListResponse::class,
            $paymentRequestListResponse
        );

        $this->assertEquals(
            $totalElementCount,
            $paymentRequestListResponse->getTotalElementCount()
        );

        $payment = $paymentRequestListResponse->getPaymentRequests()->first();

        $this->assertEquals(
            $paymentRequestToken1,
            $payment->getPaymentRequestToken()
        );

        $this->assertEquals(
            $amountInCents1,
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

        $payment = $paymentRequestListResponse->getPaymentRequests()->last();

        $this->assertEquals(
            $paymentRequestToken2,
            $payment->getPaymentRequestToken()
        );

        $this->assertEquals(
            $amountInCents2,
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
            !$payment->isOpen()
        );
    }

    /**
     * Test get payment request
     *
     * @throws Exception
     */
    public function testGetPaymentRequest()
    {
        // Variables
        $paymentRequestToken = Helper::getRandomString(20);
        $amountInCents = Helper::getRandomNumber(4);
        $referenceId = Helper::getRandomString(20);
        $description = Helper::getRandomString(20);
        $url = Helper::getRandomUrl();
        $expiryDate = Helper::getRandomFutureCarbonDate()->setTime(0, 0, 0, 0);
        $createdDateTime = Helper::getCarbonDate();
        $status = PaymentRequestResponse::OPEN;
        $numberOfPayments = Helper::getRandomNumber(1);
        $totalAmountPaidInCents = Helper::getRandomNumber(4);

        // Set the mock response
        new GetPaymentRequestsResponseMock(
            $paymentRequestToken,
            $amountInCents,
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
        $payment = $tikkie->getPaymentRequest('PAYMENT_REQUEST_TOKEN');

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
            $amountInCents,
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
     * Test the error response
     *
     * @throws Exception
     */
    public function testErrorResponse()
    {
        // Variables
        $code = ErrorResponse::DESCRIPTION_MISSING;
        $message = Helper::getRandomString(20);
        $reference = Helper::getRandomString(20);
        $traceId = Helper::getRandomString(20);
        $status = 400;

        // Set the mock response
        new ErrorResponseMock($code, $message, $reference, $traceId, $status);

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        // Get the error
        $errorListResponse = $tikkie->getPaymentRequest('PAYMENT_REQUEST_TOKEN');

        // Asserts
        $this->assertInstanceOf(
            ErrorListResponse::class,
            $errorListResponse
        );

        /**
         * @var ErrorResponse $errorResponse
         */
        $errorResponse = $errorListResponse->getErrors()->first();
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
     * Test the list of payments
     *
     * @throws Exception
     */
    public function testListPayment()
    {
        // Variables
        $totalElementCount = 1;
        $paymentToken = Helper::getRandomString(20);
        $tikkieId = Helper::getRandomNumber(10);
        $counterPartyName = Helper::getRandomString(20);
        $counterPartyAccountNumber = Helper::getRandomString(20);
        $amountInCents = Helper::getRandomNumber(4);
        $description = Helper::getRandomString(20);
        $createdDateTime = Helper::getCarbonDate();
        $refundToken = Helper::getRandomString(20);
        $refundAmount = Helper::getRandomNumber(2);
        $refundDescription = Helper::getRandomString(20);
        $refundReferenceId = Helper::getRandomString(20);
        $refundCreatedDateTime = Helper::getRandomFutureCarbonDate();
        $refundStatus = RefundResponse::STATUS_PENDING;

        // Set the mock response
        new ListPaymentsResponseMock(
            $totalElementCount,
            $paymentToken,
            $tikkieId,
            $counterPartyName,
            $counterPartyAccountNumber,
            $amountInCents,
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
        $payments = $tikkie->listPayments("PAYMENT-REQUEST-TOKEN");

        $this->assertInstanceOf(
            PaymentListResponse::class,
            $payments
        );

        $this->assertEquals(
            $totalElementCount,
            $payments->getTotalElementCount()
        );

        /** @var PaymentResponse $payment */
        $payment = $payments->getPayments()->first();

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
            $amountInCents,
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
        $refund = $payment->getRefunds()->first();

        $this->assertEquals(
            $refundToken,
            $refund->getRefundToken()
        );

        $this->assertEquals(
            $refundAmount,
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
     * Test get the payment
     *
     * @throws Exception
     */
    public function testGetPayment()
    {
        // Variables
        $paymentToken = Helper::getRandomString(20);
        $tikkieId = Helper::getRandomNumber(10);
        $counterPartyName = Helper::getRandomString(20);
        $counterPartyAccountNumber = Helper::getRandomString(20);
        $amountInCents = Helper::getRandomNumber(4);
        $description = Helper::getRandomString(20);
        $createdDateTime = Helper::getCarbonDate();
        $refundToken = Helper::getRandomString(20);
        $refundAmount = Helper::getRandomNumber(2);
        $refundDescription = Helper::getRandomString(20);
        $refundReferenceId = Helper::getRandomString(20);
        $refundCreatedDateTime = Helper::getRandomFutureCarbonDate();
        $refundStatus = RefundResponse::STATUS_PENDING;

        // Set the mock response
        new GetPaymentResponseMock(
            $paymentToken,
            $tikkieId,
            $counterPartyName,
            $counterPartyAccountNumber,
            $amountInCents,
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
        $paymentResponse = $tikkie->getPayment("PAYMENT-REQUEST-TOKEN", "PAYMENT-TOKEN");

        /**
         * Asserts
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
            $amountInCents,
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
        $refund = $paymentResponse->getRefunds()->first();

        $this->assertEquals(
            $refundToken,
            $refund->getRefundToken()
        );

        $this->assertEquals(
            $refundAmount,
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
     * Test a refund creation
     *
     * @throws Exception
     */
    public function testCreateRefund()
    {
        // Input data
        $refundToken = Helper::getRandomString(20);
        $amountInCents = Helper::getRandomNumber(4);
        $description = Helper::getRandomString(20);
        $referenceId = Helper::getRandomString(20);
        $createdDateTime = Helper::getCarbonDate();
        $status = RefundResponse::STATUS_PAID;
        $paymentRequestToken = Helper::getRandomString(20);
        $paymentToken = Helper::getRandomString(20);

        // Set the mock response
        new CreateRefundResponseMock(
            $refundToken,
            $amountInCents,
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
        $refundResponse = $tikkie->createRefund(
            $paymentRequestToken,
            $paymentToken,
            $description,
            $amountInCents,
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
            $amountInCents,
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
            ($status === RefundResponse::STATUS_PAID) ? $refundResponse->isPaid() : !$refundResponse->isPaid()
        );
    }

    /**
     * Test get the refund
     *
     * @throws Exception
     */
    public function testGetRefund()
    {
        // Variables
        $paymentRequestToken = Helper::getRandomString(20);
        $paymentToken = Helper::getRandomString(20);
        $refundToken = Helper::getRandomString(20);
        $amountInCents = Helper::getRandomNumber(4);
        $description = Helper::getRandomString(20);
        $referenceId = Helper::getRandomString(20);
        $createdDateTime = Helper::getRandomFutureCarbonDate();
        $status = RefundResponse::STATUS_PAID;

        // Set the mock response
        new GetRefundResponseMock(
            $refundToken,
            $amountInCents,
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
        $refundResponse = $tikkie->getRefund($paymentRequestToken, $paymentToken, $refundToken);

        /**
         * Asserts
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
            $amountInCents,
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
            ($status === RefundResponse::STATUS_PAID ? $refundResponse->isPaid() : !$refundResponse->isPaid())
        );
    }

    /**
     * Test a subscription creation
     *
     * @throws Exception
     */
    public function testCreateSubscription()
    {
        // Input data
        $subscriptionId = Helper::getRandomString(20);

        // Set the mock response
        new CreateSubscriptionResponseMock(
            $subscriptionId
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var SubscriptionResponse $subscriptionResponse
         */
        $subscriptionResponse = $tikkie->createSubscription(
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
     * Test a subscription deletion
     *
     * @throws Exception
     */
    public function testDeleteSubscription()
    {
        // Input data
        $traceId = Helper::getRandomString(20);

        // Set the mock response
        new DeleteSubscriptionResponseMock(
            $traceId
        );

        // Get the Tikkie object
        $tikkie = $this->getTikke();

        /**
         * @var SubscriptionDeleteResponse $subscriptionResponse
         */
        $subscriptionResponse = $tikkie->deleteSubscription();

        // Asserts
        $this->assertInstanceOf(
            SubscriptionDeleteResponse::class,
            $subscriptionResponse
        );

        $this->assertEquals(
            $traceId,
            $subscriptionResponse->getTaceId()
        );
    }
}
