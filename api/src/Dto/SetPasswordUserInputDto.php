<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class SetPasswordUserInputDto
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 100)]
    public string $password;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 200)]
    public string $token;

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        if (\strlen($this->password) < 12) {
            $context
                ->buildViolation('Password must be at least 12 characters')
                ->atPath('password')
                ->addViolation()
            ;
        }
        if (!(bool) preg_match('/[A-Z]{1,}/', $this->password)) {
            $context
                ->buildViolation('Password must contain an uppercase character')
                ->atPath('password')
                ->addViolation()
            ;
        }
        if (!(bool) preg_match('/[a-z]{1,}/', $this->password)) {
            $context
                ->buildViolation('Password must contain a lowercase character')
                ->atPath('password')
                ->addViolation()
            ;
        }
        if (!(bool) preg_match('/[0-9]{1,}/', $this->password)) {
            $context
                ->buildViolation('Password must contain a number')
                ->atPath('password')
                ->addViolation()
            ;
        }
        if (!(bool) preg_match('/[^A-Za-z0-9]{1,}/', $this->password)) {
            $context
                ->buildViolation('Password must contain a special character')
                ->atPath('password')
                ->addViolation()
            ;
        }

    }
}