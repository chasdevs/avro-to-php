## IDL to AVSC

Compile Avro IDL files into AVSC using the official [avro-tools](http://avro.apache.org/releases.html) (requires Java):

```bash
$  java -jar avro-tools-1.8.2.jar idl2schemata test/fixtures/avdl/sample-events/user/UserEvent.v1.avdl test/fixtures/avsc/sample-events
```