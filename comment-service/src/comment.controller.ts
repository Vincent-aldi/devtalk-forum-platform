import { Controller, Post, Body, Get, Patch, Delete, Param,
} from '@nestjs/common';
import { RabbitSubscribe } from '@golevelup/nestjs-rabbitmq';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Comment } from './comment.entity';

@Controller('forum')
export class CommentController {
  constructor(
    @InjectRepository(Comment)
    private readonly commentRepository: Repository<Comment>,
  ) {}

  @RabbitSubscribe({
    exchange: 'forum_exchange',
    routingKey: 'user.joined',
    queue: 'comment-service-queue',
  })
  public async handleUserJoined(msg: any) {
    console.log('--- EVENT RECEIVED ---');
    console.log('Comment Service: Sync data user baru:', msg.data.email);
  }

  @Post('comment')
  async createComment(@Body() body: { userId: number; content: string }) {
    const newComment = this.commentRepository.create({
      userId: body.userId,
      content: body.content,
    });
    return await this.commentRepository.save(newComment);
  }

  @Get('comment')
  async getAllComments() {
    return await this.commentRepository.find({
      order: { id: 'DESC' },
    });
  }

  @Patch('comment/:id')
  async updateComment(
    @Param('id') id: number,
    @Body() body: { content: string },
  ) {
    await this.commentRepository.update(id, { content: body.content });
    return { status: 'Updated', id };
  }

  @Delete('comment/:id')
  async deleteComment(@Param('id') id: number) {
    await this.commentRepository.delete(id);
    return { status: 'Deleted', id };
  }
}
