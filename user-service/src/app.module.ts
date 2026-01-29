import { Module } from '@nestjs/common';
import { RabbitMQModule } from '@golevelup/nestjs-rabbitmq';
import { AppController } from './app.controller';

@Module({
  imports: [
    RabbitMQModule.forRoot({
      exchanges: [
        {
          name: 'forum_exchange',
          type: 'topic',
        },
      ],
      uri: 'amqp://guest:guest@rabbitmq:5672',
      connectionInitOptions: { wait: true, timeout: 20000 },
    }),
  ],
  controllers: [AppController],
})
export class AppModule {}