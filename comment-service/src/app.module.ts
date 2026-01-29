import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { RabbitMQModule } from '@golevelup/nestjs-rabbitmq';
import { AppController } from './app.controller';
import { CommentController } from './comment.controller';
import { Comment } from './comment.entity';

@Module({
  imports: [
    TypeOrmModule.forRoot({
      type: 'mysql',
      host: 'db-comment',
      port: 3306,
      username: 'root',
      password: 'rootpassword',
      database: 'forum_db',
      entities: [Comment],
      synchronize: true,
    }),

    TypeOrmModule.forFeature([Comment]),

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
  controllers: [AppController, CommentController],
})
export class AppModule {}
