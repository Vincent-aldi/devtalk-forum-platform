import { Controller, Post, Body } from '@nestjs/common';
import { AmqpConnection } from '@golevelup/nestjs-rabbitmq';
import { RegisterDto } from './auth/dto/register.dto';

@Controller('auth')
export class AppController {
  constructor(private readonly amqpConnection: AmqpConnection) {}

  @Post('register')
  async register(@Body() registerDto: RegisterDto) {
    const user = { 
      userId: Math.floor(Math.random() * 1000), 
      email: registerDto.email 
    };

    this.amqpConnection.publish('forum_exchange', 'user.joined', {
      event: 'user.created',
      data: user,
    });

    return {
      message: 'User berhasil didaftarkan ke forum',
      data: user,
    };
  }
}