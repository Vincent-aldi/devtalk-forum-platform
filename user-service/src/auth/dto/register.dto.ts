import { IsEmail, MinLength } from 'class-validator';

export class RegisterDto {
  @IsEmail({}, { message: 'Format email salah' })
  email: string;

  @MinLength(6, { message: 'Password minimal 6 karakter' })
  password: string;
}