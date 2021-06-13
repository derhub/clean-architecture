# Module template

### Database Migration

 - create `composer phinx create [migrate name here]`
 - run migration `composer phinx migrate`
 - [... read phinx docs here](https://phinx.org/)


### Code generators

 - create command
 - create query
 - create event listener


### Module.php
handle the registration of query, command, events and event listener. 
Register them here to automatically handle the naming and action generations
for framework


### File structure
```
configs
├── bootstrap.php // includes on application boot you can also register dependicies here
├── mapping // doctrine mapping
└── migrations // phinx migration dir
src
├── AggregateExample // domain name
│   ├── Infrastructure // infrastructure layer
│   ├── Listeners  // Event listeners
│   ├── Model // Domain layer
│   │   ├── Events
│   │   ├── Exceptions
│   │   ├── Specifications
│   │   └── Values // value objcets dir
│   ├── Services // Application layer
│   └── Shared // shared values acroess layers
└── Module.php // module registration file
phinx.php // phinx config
```