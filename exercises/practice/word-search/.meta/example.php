<?php

declare(strict_types=1);

class WordSearch
{
    private const NEIGHBORHOOD = [
        [-1, -1], [-1, 0], [-1, 1],
        [ 0, -1],          [ 0, 1],
        [ 1, -1], [ 1, 0], [ 1, 1],
    ];

    private int $width;
    private int $height;
    private array $found;

    public function __construct(private array $grid)
    {
        $this->width  = strlen($this->grid[0]);
        $this->height = count($this->grid);
    }

    public function search(array $words): array
    {
        foreach ($words as $word) {
            for ($X = 0; $X < $this->width; $X++) {
                for ($Y = 0; $Y < $this->height; $Y++) {
                    foreach (self::NEIGHBORHOOD as [$checkX, $checkY]) {
                        $search = $this->find($word, $X, $Y, $checkX, $checkY);

                        if (isset($search)) {
                            $this->found[$word] = $search;
                            continue 4;
                        } else {
                            $this->found[$word] = null;
                        }
                    }
                }
            }
        }

        return $this->found;
    }

    private function find(string $word, int $X, int $Y, int $nextX, int $nextY): ?array
    {
        $currentX = $X;
        $currentY = $Y;

        for ($i = 0; $i < strlen($word); $i++) {
            if ($this->findNextLetter($currentX, $currentY) !== $word[$i]) {
                return null;
            }

            $currentX +=  $nextX;
            $currentY +=  $nextY;
        }

        return [
            "start" => [
                "column" => $X + 1,
                "row"    => $Y + 1
            ],
            "end"   => [
                "column" => $currentX + 1 - $nextX,
                "row"    => $currentY + 1 - $nextY
            ]
        ];
    }

    private function findNextLetter(int $X, int $Y): ?string
    {
        if ($X < 0 || $Y < 0 || $X >= $this->width || $Y >= $this->height) {
            return null;
        }

        return $this->grid[$Y][$X];
    }
}
