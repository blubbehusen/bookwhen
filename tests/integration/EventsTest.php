<?php declare(strict_types=1);

namespace InShore\Bookwhen\tests\integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use InShore\Bookwhen\Bookwhen;
use InShore\Bookwhen\BookwhenApi;
use InShore\Bookwhen\Domain\Event;
use InShore\Bookwhen\Client;
use InShore\Bookwhen\Factory;
use InShore\Bookwhen\Exceptions\ConfigurationException;
use InShore\Bookwhen\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

/**
 * @uses InShore\Bookwhen\Validator
 */
class EventsTest extends TestCase
{
    
    protected $apiKey;
    
    protected $mockHandler;
    
    protected $client;

    protected $guzzleClient;
    
    public function setUp(): void
    {
        $this->apiKey = 'dfsdsdsd';
        
        $this->mockHandler = new MockHandler();
        
        $this->guzzleClient = new GuzzleClient([
            'handler' => $this->mockHandler,
        ]);
    }
    
    /**
     * @covers InShore\Bookwhen\Bookwhen
     * @covers InShore\Bookwhen\BookwhenApi
     * @covers InShore\Bookwhen\Client
     * @covers InShore\Bookwhen\Domain\Event
     * @covers InShore\Bookwhen\Domain\Location
     * @covers InShore\Bookwhen\Domain\Ticket
     * @covers InShore\Bookwhen\Factory
     * @covers InShore\Bookwhen\Resources\Concerns\Transportable
     * @covers InShore\Bookwhen\Resources\Events
     * @covers InShore\Bookwhen\Responses\Attachments\RetrieveResponse
     * @covers InShore\Bookwhen\Responses\Events\ListResponse
     * @covers InShore\Bookwhen\Responses\Events\RetrieveResponse
     * @covers InShore\Bookwhen\Responses\Locations\RetrieveResponse
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse
     * @covers InShore\Bookwhen\Transporters\HttpTransporter
     * @covers InShore\Bookwhen\ValueObjects\ApiKey
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Headers
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Payload
     * @covers InShore\Bookwhen\ValueObjects\Transporter\QueryParams
     */
    public function testEvents(): void
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/../fixtures/events_200.json')));         
        $this->client = BookwhenApi::factory()
        ->withApiKey($this->apiKey)
        ->withHttpClient($this->guzzleClient)
        ->make();

        $bookwhen = new Bookwhen(null, $this->client);
        $events = $bookwhen->events();

        $this->assertIsArray($events);
        
        $this->assertInstanceOf(Event::class, $events[9]);
        
        $this->assertFalse($events[9]->allDay);
        // $this->assertEquals(1, $events[9]->attachments);
        $this->assertEquals(1, $events[9]->attendeeAvailable);
        $this->assertEquals(0, $events[9]->attendeeCount);
        $this->assertEquals(1, $events[9]->attendeeLimit);
        //long string for details?
        // $this->assertEquals('', $events[9]->details);
        $this->assertEquals('2023-05-08T17:00:00.000Z', $events[9]->endAt);
        $this->assertFalse($events[9]->finished);
        $this->assertEquals('ev-sjdo-20230508160000', $events[9]->id);
        $this->assertEquals('7e173fxqy8x8', $events[9]->location->id);
        $this->assertEquals(10, $events[9]->maxTicketsPerBooking);
        $this->assertEquals('2023-05-08T16:00:00.000Z', $events[9]->startAt);
        $this->assertFalse($events[9]->soldOut);
        $this->assertEquals('ti-sjdo-20230508160000-tyi9', $events[9]->tickets[0]->id);
        $this->assertEquals('I000 inShore 1 Hour Product Engineer Consultation', $events[9]->title);
        $this->assertTrue($events[9]->waitingList);





    }
}
