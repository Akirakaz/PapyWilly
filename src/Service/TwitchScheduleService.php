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

        foreach ($upcomingStreams['segments'] as $stream) {
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

                $vacationStartTime = new DateTime($upcomingStreams['vacation']['start_time']);
                $vacationEndTime = new DateTime($upcomingStreams['vacation']['end_time']);

                if ($eventStartTime >= $vacationStartTime && $eventStartTime <= $vacationEndTime) {
                    $eventStatus = [
                        'title' => 'Vacances',
                        'color' => 'yellow',
                    ];
                }

                if (!isset($schedule[$eventDate])) {
                    $schedule[$eventDate] = [];
                }

                $schedule[$eventDate][$eventTime] = [
                    'title' => $stream['title'],
                    'category' => $stream['category']['name'],
                    'start_time' => $eventStartTime,
                    'end_time' => $eventEndTime,
                    'thumbnail_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/' . $stream['category']['id'] . '-192x256.jpg',
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