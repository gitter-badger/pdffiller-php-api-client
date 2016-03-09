<?php
/**
 * Created by PhpStorm.
 * User: srg_kas
 * Date: 03.03.16
 * Time: 16:47
 */

namespace PDFfiller\OAuth2\Client\Provider\Alt;

use PDFfiller\OAuth2\Client\Provider\Core\Model;

/**
 * Class SignatureRequest
 * @package PDFfiller\OAuth2\Client\Provider\Alt
 *
 * @property string $document_id
 * @property string $method
 * @property string $envelope_name
 * @property string $security_pin
 * @property string $sign_in_order
 * @property array $recipients
 */
class SignatureRequest extends Model
{
    /**
     * @var string
     */
    protected static $entityUri = 'signature_request';

    public function attributes()
    {
        return [
            'document_id',
            'method',
            'envelope_name',
            'security_pin',
            'sign_in_order',
            'recipients',
            'date_created',
            'date_signed',
        ];
    }

    public function rules()
    {
        return [
            'method' => ['string', 'in:sendtoeach,sendtogroup', 'required'],
            'envelope_name' => ['string'],
            'status' => ['string', 'in:IN_PROGRESS,NOT_SENT,REJECTED,SENT,SIGNED'],
            'security_pin' => ['string', 'in:standard,enhanced', 'required'],
            'sign_in_order' => ['boolean'],
            'recipients' => ['array', 'required'],
            'recipients.*.email' => ['email', 'required'],
            'recipients.*.name' => ['string', 'required'],
            'recipients.*.order' => ['integer', 'required_if:sign_in_order,true'],
            'recipients.*.message_subject' => ['string', 'required'],
            'recipients.*.message_text' => ['string', 'required'],
            'recipients.*.date_created' => ['integer'],
            'recipients.*.date_signed' => ['integer'],
            'recipients.*.access' => ['string', 'in:full,signature'],
            'recipients.*.require_photo' => ['boolean'],
            'recipients.*.additional_documents' => ['array'],
            'recipients.*.additional_documents.*.document_request_notification' => ['string'],
        ];
    }

    public function __construct($provider, array $array)
    {
//        if (isset($array['recipients'])) {
//            $recipients = [];
//            foreach ($array['recipients'] as $recipient) {
//                $recipients[] = new SignatureRequestRecipient($provider, $recipient);
//            }
//        }
//        $array['recipients'] = $recipients;
        parent::__construct($provider, $array);
    }

    public function certificate() {
        return self::query($this->client, $this->id, 'certificate');
    }

    public function signedDocument() {
        return self::query($this->client, $this->id, 'signed_document');
    }
}