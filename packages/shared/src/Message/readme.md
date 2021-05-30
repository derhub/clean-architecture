# Message bus contracts base on PSR-14

 - https://www.php-fig.org/psr/psr-14/
 - https://en.wikipedia.org/wiki/Command–query_separation
 - message bus: https://www.enterpriseintegrationpatterns.com/patterns/messaging/MessageBus.html
 - command https://www.enterpriseintegrationpatterns.com/patterns/messaging/CommandMessage.html
 - event: https://www.enterpriseintegrationpatterns.com/patterns/messaging/EventMessage.html 

Notes:
 - Commands: change the state of the system and return if success, error message and affected aggregate id
 - Queries: Return the result and does not perform any state change
 - Commands & Queries can only have one handler
 - event handlers sometimes called Saga or Process Manger
 - handler should return Common Response object when it's a Command handler or Query handler
 - handler should return null or void if it's Event Handler