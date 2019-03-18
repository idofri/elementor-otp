<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd66773d61590c19b2dff6272f3c4a378
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
        'cf97c57bfe0f23854afd2f3818abb7a0' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/create_uploaded_file.php',
        '9bf37a3d0dad93e29cb4e1b1bfab04e9' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/marshal_headers_from_sapi.php',
        'ce70dccb4bcc2efc6e94d2ee526e6972' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/marshal_method_from_sapi.php',
        'f86420df471f14d568bfcb71e271b523' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/marshal_protocol_version_from_sapi.php',
        'b87481e008a3700344428ae089e7f9e5' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/marshal_uri_from_sapi.php',
        '0b0974a5566a1077e4f2e111341112c1' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/normalize_server.php',
        '1ca3bc274755662169f9629d5412a1da' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/normalize_uploaded_files.php',
        '40360c0b9b437e69bcbb7f1349ce029e' => __DIR__ . '/..' . '/zendframework/zend-diactoros/src/functions/parse_cookie_header.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\Diactoros\\' => 15,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'N' => 
        array (
            'Nexmo\\' => 6,
        ),
        'L' => 
        array (
            'Lcobucci\\JWT\\' => 13,
        ),
        'H' => 
        array (
            'Http\\Promise\\' => 13,
            'Http\\Client\\' => 12,
            'Http\\Adapter\\Guzzle6\\' => 21,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'E' => 
        array (
            'Elementor\\OTP\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\Diactoros\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zend-diactoros/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Nexmo\\' => 
        array (
            0 => __DIR__ . '/..' . '/nexmo/client/src',
        ),
        'Lcobucci\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/lcobucci/jwt/src',
        ),
        'Http\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/promise/src',
        ),
        'Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/httplug/src',
        ),
        'Http\\Adapter\\Guzzle6\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/guzzle6-adapter/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Elementor\\OTP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'A' => 
        array (
            'Authy' => 
            array (
                0 => __DIR__ . '/..' . '/authy/php/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Plivo\\Authentication\\BasicAuth' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Authentication/BasicAuth.php',
        'Plivo\\BaseClient' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/BaseClient.php',
        'Plivo\\Exceptions\\PlivoAuthenticationException' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Exceptions/PlivoAuthenticationException.php',
        'Plivo\\Exceptions\\PlivoNotFoundException' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Exceptions/PlivoNotFoundException.php',
        'Plivo\\Exceptions\\PlivoRequestException' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Exceptions/PlivoRequestException.php',
        'Plivo\\Exceptions\\PlivoResponseException' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Exceptions/PlivoResponseException.php',
        'Plivo\\Exceptions\\PlivoRestException' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Exceptions/PlivoRestException.php',
        'Plivo\\Exceptions\\PlivoServerException' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Exceptions/PlivoServerException.php',
        'Plivo\\Exceptions\\PlivoValidationException' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Exceptions/PlivoValidationException.php',
        'Plivo\\Exceptions\\PlivoXMLException' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Exceptions/PlivoXMLException.php',
        'Plivo\\HttpClients\\HttpClientsFactory' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/HttpClients/HttpClientsFactory.php',
        'Plivo\\HttpClients\\PlivoGuzzleHttpClient' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/HttpClients/PlivoGuzzleHttpClient.php',
        'Plivo\\HttpClients\\PlivoHttpClientInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/HttpClients/PlivoHttpClientInterface.php',
        'Plivo\\Http\\PlivoRequest' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Http/PlivoRequest.php',
        'Plivo\\Http\\PlivoResponse' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Http/PlivoResponse.php',
        'Plivo\\Resources\\Account\\Account' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Account/Account.php',
        'Plivo\\Resources\\Account\\AccountInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Account/AccountInterface.php',
        'Plivo\\Resources\\Account\\Address\\AddressInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Account/Address/AddressInterface.php',
        'Plivo\\Resources\\Application\\Application' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Application/Application.php',
        'Plivo\\Resources\\Application\\ApplicationCreateResponse' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Application/ApplicationCreateResponse.php',
        'Plivo\\Resources\\Application\\ApplicationInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Application/ApplicationInterface.php',
        'Plivo\\Resources\\Application\\ApplicationList' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Application/ApplicationList.php',
        'Plivo\\Resources\\Call\\Call' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Call/Call.php',
        'Plivo\\Resources\\Call\\CallCreateResponse' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Call/CallCreateResponse.php',
        'Plivo\\Resources\\Call\\CallInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Call/CallInterface.php',
        'Plivo\\Resources\\Call\\CallList' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Call/CallList.php',
        'Plivo\\Resources\\Call\\CallLive' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Call/CallLive.php',
        'Plivo\\Resources\\Call\\CallQueued' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Call/CallQueued.php',
        'Plivo\\Resources\\Call\\CallRecording' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Call/CallRecording.php',
        'Plivo\\Resources\\Conference\\Conference' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Conference/Conference.php',
        'Plivo\\Resources\\Conference\\ConferenceInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Conference/ConferenceInterface.php',
        'Plivo\\Resources\\Conference\\ConferenceMember' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Conference/ConferenceMember.php',
        'Plivo\\Resources\\Conference\\ConferenceRecording' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Conference/ConferenceRecording.php',
        'Plivo\\Resources\\Endpoint\\Endpoint' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Endpoint/Endpoint.php',
        'Plivo\\Resources\\Endpoint\\EndpointCreateReponse' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Endpoint/EndpointCreateReponse.php',
        'Plivo\\Resources\\Endpoint\\EndpointInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Endpoint/EndpointInterface.php',
        'Plivo\\Resources\\Message\\Message' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Message/Message.php',
        'Plivo\\Resources\\Message\\MessageCreateResponse' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Message/MessageCreateResponse.php',
        'Plivo\\Resources\\Message\\MessageInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Message/MessageInterface.php',
        'Plivo\\Resources\\Message\\MessageList' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Message/MessageList.php',
        'Plivo\\Resources\\Number\\Number' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Number/Number.php',
        'Plivo\\Resources\\Number\\NumberInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Number/NumberInterface.php',
        'Plivo\\Resources\\PHLO\\ConferenceBridge\\ConferenceBridge' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/ConferenceBridge/ConferenceBridge.php',
        'Plivo\\Resources\\PHLO\\ConferenceBridge\\ConferenceBridgeMember' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/ConferenceBridge/ConferenceBridgeMember.php',
        'Plivo\\Resources\\PHLO\\MultiPartyCall\\MultiPartyCall' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/MultiiPartyCall/MultiPartyCall.php',
        'Plivo\\Resources\\PHLO\\MultiPartyCall\\MultiPartyCallMember' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/MultiiPartyCall/MultiPartyCallMember.php',
        'Plivo\\Resources\\PHLO\\Node\\NodeClass' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/Node/NodeClass.php',
        'Plivo\\Resources\\PHLO\\Node\\NodeMember' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/Node/NodeMember.php',
        'Plivo\\Resources\\PHLO\\Phlo' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/Phlo.php',
        'Plivo\\Resources\\PHLO\\PhloRestClient' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/PhloRestClient.php',
        'Plivo\\Resources\\PHLO\\Phlorunner' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PHLO/Phlorunner.php',
        'Plivo\\Resources\\PhoneNumber\\PhoneNumber' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PhoneNumber/PhoneNumber.php',
        'Plivo\\Resources\\PhoneNumber\\PhoneNumberBuyResponse' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PhoneNumber/PhoneNumberBuyResponse.php',
        'Plivo\\Resources\\PhoneNumber\\PhoneNumberInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/PhoneNumber/PhoneNumberInterface.php',
        'Plivo\\Resources\\Pricing\\Inbound' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/Inbound.php',
        'Plivo\\Resources\\Pricing\\Local' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/Local.php',
        'Plivo\\Resources\\Pricing\\Message' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/Message.php',
        'Plivo\\Resources\\Pricing\\Outbound' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/Outbound.php',
        'Plivo\\Resources\\Pricing\\OutboundNetwork' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/OutboundNetwork.php',
        'Plivo\\Resources\\Pricing\\PhoneNumbers' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/PhoneNumbers.php',
        'Plivo\\Resources\\Pricing\\Pricing' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/Pricing.php',
        'Plivo\\Resources\\Pricing\\PricingInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/PricingInterface.php',
        'Plivo\\Resources\\Pricing\\Tollfree' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/Tollfree.php',
        'Plivo\\Resources\\Pricing\\Voice' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Pricing/Voice.php',
        'Plivo\\Resources\\Recording\\Recording' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Recording/Recording.php',
        'Plivo\\Resources\\Recording\\RecordingInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Recording/RecordingInterface.php',
        'Plivo\\Resources\\Resource' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/Resource.php',
        'Plivo\\Resources\\ResourceInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/ResourceInterface.php',
        'Plivo\\Resources\\ResourceList' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/ResourceList.php',
        'Plivo\\Resources\\ResponseDelete' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/ResponseDelete.php',
        'Plivo\\Resources\\ResponseUpdate' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/ResponseUpdate.php',
        'Plivo\\Resources\\SubAccount\\SubAccount' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/SubAccount/SubAccount.php',
        'Plivo\\Resources\\SubAccount\\SubAccountCreateResponse' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/SubAccount/SubAccountCreateResponse.php',
        'Plivo\\Resources\\SubAccount\\SubAccountInterface' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/SubAccount/SubAccountInterface.php',
        'Plivo\\Resources\\SubAccount\\SubAccountList' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Resources/SubAccount/SubAccountList.php',
        'Plivo\\RestClient' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/RestClient.php',
        'Plivo\\Tests\\BaseTestCase' => __DIR__ . '/..' . '/plivo/php-sdk/tests/BaseTestCase.php',
        'Plivo\\Tests\\Resources\\MessageTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/MessageTest.php',
        'Plivo\\Tests\\Resources\\SubAccountTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/SubAccountTest.php',
        'Plivo\\Tests\\TestClient' => __DIR__ . '/..' . '/plivo/php-sdk/tests/TestClient.php',
        'Plivo\\Util\\ArrayOperations' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Util/ArrayOperations.php',
        'Plivo\\Util\\signatureValidation' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Util/signatureValidation.php',
        'Plivo\\Version' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/Version.php',
        'Plivo\\XML\\Conference' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Conference.php',
        'Plivo\\XML\\DTMF' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/DTMF.php',
        'Plivo\\XML\\Dial' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Dial.php',
        'Plivo\\XML\\Element' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Element.php',
        'Plivo\\XML\\GetDigits' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/GetDigits.php',
        'Plivo\\XML\\Hangup' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Hangup.php',
        'Plivo\\XML\\Message' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Message.php',
        'Plivo\\XML\\Number' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Number.php',
        'Plivo\\XML\\Play' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Play.php',
        'Plivo\\XML\\PlivoXML' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/PlivoXML.php',
        'Plivo\\XML\\PreAnswer' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/PreAnswer.php',
        'Plivo\\XML\\Record' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Record.php',
        'Plivo\\XML\\Redirect' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Redirect.php',
        'Plivo\\XML\\Response' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Response.php',
        'Plivo\\XML\\Speak' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Speak.php',
        'Plivo\\XML\\User' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/User.php',
        'Plivo\\XML\\Wait' => __DIR__ . '/..' . '/plivo/php-sdk/src/Plivo/XML/Wait.php',
        'Resources\\AccountTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/AccountTest.php',
        'Resources\\ApplicationTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/ApplicationTest.php',
        'Resources\\CallTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/CallTest.php',
        'Resources\\ConferenceTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/ConferenceTest.php',
        'Resources\\EndpointTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/EndpointTest.php',
        'Resources\\NumberTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/NumberTest.php',
        'Resources\\PhoneNumberTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/PhoneNumberTest.php',
        'Resources\\PricingTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/PricingTest.php',
        'Resources\\RecordingTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/Resources/RecordingTest.php',
        'UtilTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/UtilTest.php',
        'XmlTest' => __DIR__ . '/..' . '/plivo/php-sdk/tests/XmlTest.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd66773d61590c19b2dff6272f3c4a378::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd66773d61590c19b2dff6272f3c4a378::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitd66773d61590c19b2dff6272f3c4a378::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitd66773d61590c19b2dff6272f3c4a378::$classMap;

        }, null, ClassLoader::class);
    }
}
