<?php

namespace App\Service;

use DateTime;

class TwitchScheduleService
{
    /**
     * @throws \Exception
     */
    public function render(array $upcomingStreams): array
    {
        $weekNow = new DateTime('now');
        $weekNow->setISODate($weekNow->format('Y'), $weekNow->format('W'));
        $weekStart = $weekNow->format('Y-m-d') . 'T00:00:00Z';

        $weekNow->modify('next Sunday');
        $weekEnd = $weekNow->format('Y-m-d') . 'T23:59:59Z';

        $schedule = [];
        $streams = $upcomingStreams['segments'] ?? [];

        foreach ($streams as $stream) {
            $now = new DateTime('now');

            $eventStartTime = new DateTime($stream['start_time']);
            $eventEndTime = new DateTime($stream['end_time']);

            $eventDate = $eventStartTime->format('Y-m-d');
            $eventTime = $eventStartTime->format('H:i');

            if ($eventStartTime < $now && $eventEndTime >= $now) {
                $eventStatus = [
                    'title' => 'En cours',
                    'color' => 'blue',
                ];
            } elseif ($eventStartTime > $now) {
                $eventStatus = [
                    'title' => 'Prochainement',
                    'color' => 'green',
                ];
            } else {
                $eventStatus = [
                    'title' => 'Terminé',
                    'color' => 'orange',
                ];
            }

            if ($eventStartTime >= new DateTime($weekStart) && $eventStartTime <= new DateTime($weekEnd)) {
                if (isset($stream['canceled_until'])) {
                    $eventStatus = [
                        'title' => 'Annulé',
                        'color' => 'red',
                    ];
                }

                $vacationStartTime = isset($upcomingStreams['vacation']) ? new DateTime($upcomingStreams['vacation']['start_time']) : null;
                $vacationEndTime = isset($upcomingStreams['vacation']) ? new DateTime($upcomingStreams['vacation']['end_time']) : null;

                if ($eventStartTime >= $vacationStartTime && $eventStartTime <= $vacationEndTime) {
                    $eventStatus = [
                        'title' => 'Vacances',
                        'color' => 'yellow',
                    ];
                }

                if (!isset($schedule[$eventDate])) {
                    $schedule[$eventDate] = [];
                }

                $categoryName = isset($stream['category']) ? $stream['category']['name'] : null;
                $thumbnailUrl = isset($stream['category']) ? 'https://static-cdn.jtvnw.net/ttv-boxart/' . $stream['category']['id'] . '-192x256.jpg' : null;

                $schedule[$eventDate][$eventTime] = [
                    'title' => $stream['title'],
                    'category' => $categoryName,
                    'start_time' => $eventStartTime,
                    'end_time' => $eventEndTime,
                    'thumbnail_url' => $thumbnailUrl,
                    'status' => $eventStatus,
                ];
            }
        }

        return [
            'schedule' => $schedule,
            'scheduleWeek' => [
                'start' => $weekStart,
                'end' => $weekEnd,
            ],
        ];
    }
}