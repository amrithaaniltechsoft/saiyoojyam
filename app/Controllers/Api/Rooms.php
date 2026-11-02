<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Config\Database;

class Rooms extends BaseController
{
    private function setCorsHeaders()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    public function index()
    {
        $this->setCorsHeaders();

        $db = Database::connect();

        $locationParam  = strtolower(trim((string) $this->request->getGet('location')));
        $dateParam      = trim((string) $this->request->getGet('date'));
        $roomTypeParam  = trim((string) $this->request->getGet('roomType'));
        $filterParam    = trim((string) $this->request->getGet('filter'));

        $today = date('Y-m-d');
        $checkInDate = !empty($dateParam) ? $dateParam : $today;
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $checkInDate)) {
            $checkInDate = $today;
        }

        $searchDate  = $checkInDate;
        $windowStart = date('Y-m-d', strtotime($searchDate . ' -10 days'));
        $windowEnd   = date('Y-m-d', strtotime($searchDate . ' +5 days'));
        $todayPlus10 = date('Y-m-d', strtotime($today . ' +10 days'));

        // 1. Fetch Buildings
        $buildings = [];
        if ($db->tableExists('saiyoojyam_building')) {
            $buildings = $db->table('saiyoojyam_building')
                ->orderBy('building_id', 'ASC')
                ->get()
                ->getResult();
        }

        $buildingMap = [];
        foreach ($buildings as $b) {
            $dbSlug = strtolower(trim($b->building_slug ?? ''));
            $cleanSlug = trim(preg_replace('/^saiyoojyam[-_]/i', '', $dbSlug));
            if (!empty($cleanSlug)) {
                $bKey = $cleanSlug;
            } elseif (!empty($dbSlug)) {
                $bKey = $dbSlug;
            } else {
                $nameLower = strtolower(trim($b->building_name ?? ''));
                $bKey = preg_replace('/[^a-z0-9]+/i', '-', trim(str_replace('saiyoojyam', '', $nameLower)));
                $bKey = trim($bKey, '-');
                if (empty($bKey)) {
                    $bKey = 'b-' . $b->building_id;
                }
            }
            $rawTagline = trim($b->building_tagline ?? '');
            $cleanTagline = stripos($rawTagline, 'sfsdfsd') !== false ? '' : $rawTagline;
            $cleanName = trim(preg_replace('/\s*\(?\b(?:sfsdfsd)\b\)?/i', '', $b->building_name ?? ''));
            if (empty($cleanName)) {
                $cleanName = $b->building_name ?? '';
            }

            $baseUrl = rtrim(base_url(), '/') . '/';
            $bImage = '';
            if (!empty($b->building_image)) {
                $bImage = $baseUrl . 'public/uploads/buildings/' . $b->building_image;
            } elseif (strpos($bKey, 'tower') !== false) {
                $bImage = '/buildings/saiyoojyam-towers/s1.png';
            } elseif (strpos($bKey, 'premier') !== false) {
                $bImage = '/buildings/saiyoojyam-premier/s1.png';
            } elseif (strpos($bKey, 'annex') !== false) {
                $bImage = '/buildings/saiyoojyam-annex/s1.png';
            }

            $bAf = 0;
            if (isset($b->building_admission_fees) && $b->building_admission_fees !== '') {
                $bAf = (float) preg_replace('/[^\d.]/', '', (string) $b->building_admission_fees);
            }
            $bCd = 0;
            if (isset($b->building_caution_deposit) && $b->building_caution_deposit !== '') {
                $bCd = (float) preg_replace('/[^\d.]/', '', (string) $b->building_caution_deposit);
            }

            $buildingMap[$b->building_id] = [
                'id'              => (int) $b->building_id,
                'name'            => $cleanName,
                'slug'            => $bKey,
                'tagline'         => $cleanTagline,
                'address'         => $b->building_address ?? '',
                'building_address'=> $b->building_address ?? '',
                'whatsapp'        => !empty($b->building_whatsapp) ? $b->building_whatsapp : '917034111368',
                'image'           => $bImage,
                'admission_fees'  => $bAf,
                'caution_deposit' => $bCd,
            ];
        }

        // 2. Fetch Room Types
        $roomTypes = [];
        if ($db->tableExists('saiyoojyam_room_type')) {
            $roomTypes = $db->table('saiyoojyam_room_type')
                ->orderBy('room_type_id', 'ASC')
                ->get()
                ->getResult();
        }
        $roomTypeMap = [];
        $buildingCategories = [];
        foreach ($roomTypes as $rt) {
            $rtName = trim($rt->room_type_name ?? '');
            $rtSlug = trim($rt->room_type_slug ?? '');
            $bId = (int) ($rt->room_type_building_id ?? 0);
            $bKey = isset($buildingMap[$bId]) ? $buildingMap[$bId]['slug'] : '';

            $isNonAc = (stripos($rtName, 'non-ac') !== false || stripos($rtName, 'non ac') !== false);
            $isAc = !$isNonAc && stripos($rtName, 'ac') !== false;

            $shares = 1;
            if (preg_match('/(\d+)\s*(?:share|bed|sharing)/i', $rtName, $m)) {
                $shares = (int) $m[1];
            } elseif (stripos($rtName, 'single') !== false) {
                $shares = 1;
            }

            $filterId = !empty($rtSlug) ? $rtSlug : ($bKey . '-' . strtolower(preg_replace('/[^a-z0-9]+/i', '-', $rtName)));

            $categoryObj = [
                'id'       => $filterId,
                'label'    => $rtName,
                'shares'   => $shares,
                'isAc'     => $isAc,
                'building' => $bKey,
                'dbId'     => (int) $rt->room_type_id,
            ];

            $roomTypeMap[$rt->room_type_id] = [
                'id'             => (int) $rt->room_type_id,
                'value'          => (string) $rt->room_type_id,
                'label'          => $rtName,
                'name'           => $rtName,
                'room_type_name' => $rtName,
                'room_type_id'   => (int) $rt->room_type_id,
                'building_id'    => $bId,
                'building_key'   => $bKey,
                'slug'           => $rtSlug,
                'shares'         => $shares,
                'isAc'           => $isAc,
                'filterId'       => $filterId,
            ];

            if ($bKey) {
                if (!isset($buildingCategories[$bKey])) {
                    $buildingCategories[$bKey] = [];
                }
                $buildingCategories[$bKey][] = $categoryObj;
            }
        }

        // 3. Fetch Tariffs
        $tariffsByRoom = [];
        $tariffsByType = [];
        $tariffsMetaByRoom = [];
        $tariffsMetaByType = [];
        if ($db->tableExists('saiyoojyam_tariffs')) {
            $tariffs = $db->table('saiyoojyam_tariffs')->orderBy('tariffs_id', 'DESC')->get()->getResult();
            foreach ($tariffs as $tf) {
                $price = (float) ($tf->tariffs_price ?? 0);
                if ($price <= 0) continue;

                $cleanAf = 0;
                if (isset($tf->tariffs_admission_fees) && $tf->tariffs_admission_fees !== '') {
                    $cleanAf = (float) preg_replace('/[^\d.]/', '', (string) $tf->tariffs_admission_fees);
                }

                $cleanCd = 0;
                if (isset($tf->tariffs_caution_deposit) && $tf->tariffs_caution_deposit !== '') {
                    $cleanCd = (float) preg_replace('/[^\d.]/', '', (string) $tf->tariffs_caution_deposit);
                }

                if (!empty($tf->tariffs_rooms)) {
                    $rIds = explode(',', (string) $tf->tariffs_rooms);
                    foreach ($rIds as $rawRid) {
                        $rId = (int) trim($rawRid);
                        if ($rId > 0 && !isset($tariffsByRoom[$rId])) {
                            $tariffsByRoom[$rId] = $price;
                            $tariffsMetaByRoom[$rId] = [
                                'price'           => $price,
                                'admission_fees'  => $cleanAf,
                                'caution_deposit' => $cleanCd,
                            ];
                        }
                    }
                }
                if (!empty($tf->tariffs_building) && !empty($tf->tariffs_room_types)) {
                    $key = $tf->tariffs_building . '_' . $tf->tariffs_room_types;
                    if (!isset($tariffsByType[$key])) {
                        $tariffsByType[$key] = $price;
                        $tariffsMetaByType[$key] = [
                            'price'           => $price,
                            'admission_fees'  => $cleanAf,
                            'caution_deposit' => $cleanCd,
                        ];
                    }
                }
            }
        }

        // 4. Helper function to map feature names to frontend icons
        $getFeatureIcon = function ($featureName) {
            $fn = strtolower(trim((string) $featureName));
            if (strpos($fn, 'bath') !== false || strpos($fn, 'wash') !== false || strpos($fn, 'toilet') !== false || strpos($fn, 'shower') !== false) {
                return 'ShowerHead';
            }
            if (strpos($fn, 'fan') !== false || strpos($fn, 'vent') !== false) {
                return 'Wind';
            }
            if (preg_match('/\bac\b|air\s*condition|split\s*ac/i', $fn)) {
                return 'Wind';
            }
            if (strpos($fn, 'food') !== false || strpos($fn, 'tiffin') !== false || strpos($fn, 'meal') !== false || strpos($fn, 'kitchen') !== false || strpos($fn, 'fridge') !== false || strpos($fn, 'refrigerator') !== false) {
                return 'Utensils';
            }
            if (strpos($fn, 'wifi') !== false || strpos($fn, 'wi-fi') !== false || strpos($fn, 'internet') !== false) {
                return 'Wifi';
            }
            if (strpos($fn, 'power') !== false || strpos($fn, 'backup') !== false || strpos($fn, 'generator') !== false || strpos($fn, 'inverter') !== false || strpos($fn, 'iron') !== false || strpos($fn, 'machine') !== false) {
                return 'Zap';
            }
            if (strpos($fn, 'balcony') !== false || strpos($fn, 'lift') !== false || strpos($fn, 'elevator') !== false) {
                return 'Building';
            }
            if (strpos($fn, 'study') !== false || strpos($fn, 'desk') !== false || strpos($fn, 'book') !== false) {
                return 'BookOpen';
            }
            if (strpos($fn, 'window') !== false || strpos($fn, 'sun') !== false) {
                return 'Sun';
            }
            if (strpos($fn, 'lock') !== false || strpos($fn, 'security') !== false) {
                return 'Lock';
            }
            if (strpos($fn, 'bus') !== false || strpos($fn, 'cab') !== false || strpos($fn, 'parking') !== false) {
                return 'Bus';
            }
            return 'CheckCircle2';
        };

        // Fetch all room features from saiyoojyam_room_feature
        $roomFeaturesMap = [];
        if ($db->tableExists('saiyoojyam_room_feature')) {
            $rfRows = $db->table('saiyoojyam_room_feature')->get()->getResult();
            $baseUrl = rtrim(base_url(), '/') . '/';
            foreach ($rfRows as $rf) {
                $fId = (int) $rf->feature_id;
                $fName = trim($rf->feature_name ?? '');
                $fImage = trim($rf->feature_image ?? '');
                $roomFeaturesMap[$fId] = [
                    'id'    => $fId,
                    'name'  => $fName,
                    'image' => !empty($fImage) ? $baseUrl . 'public/uploads/feature/' . $fImage : '',
                    'icon'  => $getFeatureIcon($fName),
                ];
            }
        }

        // 5. Fetch Rooms from saiyoojyam_rooms with Room Type join
        $dbRooms = [];
        if ($db->tableExists('saiyoojyam_rooms')) {
            $builder = $db->table('saiyoojyam_rooms');
            if ($db->tableExists('saiyoojyam_room_type')) {
                $builder->select('saiyoojyam_rooms.*, saiyoojyam_room_type.room_type_name, saiyoojyam_room_type.room_type_slug, saiyoojyam_room_type.room_type_building_id');
                $builder->join('saiyoojyam_room_type', 'saiyoojyam_room_type.room_type_id = saiyoojyam_rooms.rooms_type', 'left');
            }
            $builder->orderBy('saiyoojyam_rooms.rooms_building', 'ASC')->orderBy('saiyoojyam_rooms.rooms_name', 'ASC');
            $dbRooms = $builder->get()->getResult();
        }

        $formattedRooms = [];

        if (!empty($dbRooms)) {
            foreach ($dbRooms as $r) {
                $bInfo = $buildingMap[$r->rooms_building] ?? [
                    'id'       => (int) ($r->rooms_building ?? 1),
                    'name'     => 'Saiyoojyam Hostel',
                    'slug'     => 'annex',
                    'tagline'  => 'Kakkanad, Kochi',
                    'address'  => 'Kakkanad, Kochi',
                    'whatsapp' => '917034111368',
                ];

                $rtNameJoined = !empty($r->room_type_name) ? trim($r->room_type_name) : '';
                $rtInfo = $roomTypeMap[$r->rooms_type] ?? [
                    'id'   => (int) ($r->rooms_type ?? 0),
                    'name' => $rtNameJoined ?: 'Standard Room',
                    'slug' => !empty($r->room_type_slug) ? trim($r->room_type_slug) : '',
                ];

                $bKey = $bInfo['slug'];
                $capacity = (int) ($r->rooms_capacity ?? 0);
                if ($capacity <= 0) {
                    $typeNameProbe = $rtNameJoined ?: $rtInfo['name'];
                    if (preg_match('/(\d+)\s*(?:share|bed|sharing)/i', $typeNameProbe, $m)) {
                        $capacity = (int) $m[1];
                    } elseif (stripos($typeNameProbe, 'single') !== false) {
                        $capacity = 1;
                    } else {
                        $capacity = 1;
                    }
                }



                // Room Type Name & AC detection
                $typeName = $rtNameJoined ?: ($rtInfo['name'] ?? '');
                if (empty($typeName) || $typeName === 'Standard Room') {
                    if (!empty($r->rooms_ac_type)) {
                        $typeName = $capacity > 0 ? "{$capacity} Share {$r->rooms_ac_type}" : $r->rooms_ac_type;
                    } elseif ($capacity > 0) {
                        $typeName = "{$capacity} Share";
                    } else {
                        $typeName = 'Standard Room';
                    }
                }

                $roomName = $r->rooms_name ?? '';
                $isNonAc = (stripos($typeName, 'non-ac') !== false || stripos($typeName, 'non ac') !== false || stripos($roomName, 'non-ac') !== false || (!empty($r->rooms_ac_type) && stripos($r->rooms_ac_type, 'non') !== false));
                $isAc = !$isNonAc && (stripos($typeName, 'ac') !== false || stripos($roomName, 'ac') !== false || (!empty($r->rooms_ac_type) && stripos($r->rooms_ac_type, 'ac') !== false));
                $badgeCategory = $isAc ? 'AC Room' : '';

                // Rent lookup: ONLY rooms with an added tariff in saiyoojyam_tariffs should appear in frontend
                $rentPrice = 0;
                $hasTariff = false;
                $af = 0;
                $cd = 0;

                $roomId = (int) $r->rooms_id;
                $bId = (int) $r->rooms_building;
                $typeId = (int) $r->rooms_type;

                // STRICT: Only rooms specifically listed in saiyoojyam_tariffs.tariffs_rooms are shown
                if (isset($tariffsByRoom[$roomId]) && $tariffsByRoom[$roomId] > 0) {
                    $rentPrice = $tariffsByRoom[$roomId];
                    $hasTariff = true;
                    $af = (float) ($tariffsMetaByRoom[$roomId]['admission_fees'] ?? 0);
                    $cd = (float) ($tariffsMetaByRoom[$roomId]['caution_deposit'] ?? 0);
                    if ($af <= 0 && !empty($buildingMap[$bId]['admission_fees'])) {
                        $af = (float) $buildingMap[$bId]['admission_fees'];
                    }
                    if ($cd <= 0 && !empty($buildingMap[$bId]['caution_deposit'])) {
                        $cd = (float) $buildingMap[$bId]['caution_deposit'];
                    }
                }

                // If this room has NO tariff added in saiyoojyam_tariffs, skip it completely
                if (!$hasTariff || $rentPrice <= 0) {
                    continue;
                }

                // Client Search Availability Rules:
                // 1. "Show results only from 10 days prior and 5 days later to the search date."
                // 2. "(For any rooms vacated earlier and not booked till today, list it in the search results for all the dates until 10 days ahead of today including today's)"
                $roomInmates = [];
                if ($db->tableExists('saiyoojyam_inmates')) {
                    $roomInmates = $db->table('saiyoojyam_inmates')
                        ->where('inmates_rooms', $roomId)
                        ->whereNotIn('inmates_status', ['rejected', 'cancelled', 'inactive'])
                        ->get()
                        ->getResult();
                }

                // Helper to calculate free beds on any date
                $getFreeBedsOnDate = function($checkDate) use ($roomInmates, $capacity) {
                    $occ = 0;
                    foreach ($roomInmates as $inm) {
                        $st = strtolower(trim($inm->inmates_status ?? ''));
                        if (in_array($st, ['checked_out', 'checkout', 'rejected', 'cancelled', 'inactive'])) {
                            continue;
                        }
                        $cIn = $inm->inmates_check_in_date ?? '';
                        $cOut = $inm->inmates_check_out_date ?? '';
                        if (!empty($cIn) && $cIn <= $checkDate) {
                            if (empty($cOut) || $cOut === '0000-00-00' || $cOut > $checkDate) {
                                $occ++;
                            }
                        }
                    }
                    return max(0, $capacity - $occ);
                };

                // Helper to check if a room has sustained free beds from a date forward (at least 2 days so it's not a 1-day transient gap)
                $hasSustainedAvailability = function($startDate, $days = 2) use ($getFreeBedsOnDate) {
                    for ($d = 0; $d <= $days; $d++) {
                        $cDate = date('Y-m-d', strtotime($startDate . " +$d days"));
                        if ($getFreeBedsOnDate($cDate) <= 0) {
                            return false;
                        }
                    }
                    return true;
                };

                $freeBedsToday = $getFreeBedsOnDate($today);
                $freeBedsOnSearch = $getFreeBedsOnDate($searchDate);

                // Room is available on searchDate if freeBedsOnSearch > 0 AND it does not immediately become 100% full the next day
                $isSearchDateAvailable = ($freeBedsOnSearch > 0 && $hasSustainedAvailability($searchDate, 2));

                // Rule A: Earlier vacated and not booked till today (valid for search dates from today until 10 days ahead of today)
                $ruleAMatches = ($freeBedsToday > 0 && $searchDate >= $today && $searchDate <= $todayPlus10 && $isSearchDateAvailable);

                // Check for beds vacated in past window [searchDate - 10 days, searchDate]
                // OR beds scheduled to vacate in upcoming window (searchDate, searchDate + 5 days]
                $pastVacateFound = false;
                $upcomingVacateFound = false;
                $earliestUpcomingDate = null;
                $upcomingVacatingBeds = 0;

                foreach ($roomInmates as $inm) {
                    $st = strtolower(trim($inm->inmates_status ?? ''));
                    if (in_array($st, ['rejected', 'cancelled', 'inactive'])) {
                        continue;
                    }
                    $outDate = $inm->inmates_check_out_date ?? '';
                    if (!empty($outDate) && $outDate !== '0000-00-00') {
                        if ($outDate >= $windowStart && $outDate <= $searchDate) {
                            if ($isSearchDateAvailable) {
                                $pastVacateFound = true;
                            }
                        } elseif ($outDate > $searchDate && $outDate <= $windowEnd) {
                            // Bed scheduled to vacate in upcoming window (searchDate, searchDate + 5 days]:
                            // It must be genuinely available starting from outDate (not immediately 100% full on subsequent days)
                            if ($hasSustainedAvailability($outDate, 2)) {
                                $upcomingVacateFound = true;
                                $upcomingVacatingBeds++;
                                if ($earliestUpcomingDate === null || $outDate < $earliestUpcomingDate) {
                                    $earliestUpcomingDate = $outDate;
                                }
                            }
                        }
                    }
                }

                // Eligibility check:
                // 1) If free beds exist on search date AND room meets Rule A or had a bed vacate in [searchDate - 10 days, searchDate]
                // 2) OR if room has an upcoming bed vacating within 5 days later (searchDate, searchDate + 5 days]
                // If all beds are booked on search date and NO genuine upcoming beds are vacating, exclude this room!
                $isEligible = false;
                $isUpcomingVacancy = false;
                $availableFromDate = $searchDate;
                $availableFromDisplay = 'Available Now';
                $availableBeds = 0;
                $vacateDate = null;

                if ($isSearchDateAvailable && ($ruleAMatches || $pastVacateFound)) {
                    $isEligible = true;
                    $availableFromDate = $searchDate;
                    $availableFromDisplay = 'Available Now';
                    $availableBeds = $freeBedsOnSearch;
                    $bedsFreeText = ($availableBeds === 1) ? '1 Bed Free' : "{$availableBeds} Beds Free";
                } elseif ($upcomingVacateFound && $earliestUpcomingDate !== null) {
                    $isEligible = true;
                    $isUpcomingVacancy = true;
                    $vacateDate = $earliestUpcomingDate;
                    $availableFromDate = $earliestUpcomingDate;
                    $availableBeds = $upcomingVacatingBeds;
                    $formattedVacate = date('M j, Y', strtotime($earliestUpcomingDate));
                    $availableFromDisplay = "Available from {$formattedVacate}";
                    $bedsFreeText = "Available from " . date('M j', strtotime($earliestUpcomingDate));
                }

                if (!$isEligible || $availableBeds <= 0) {
                    continue;
                }

                if ($af <= 0 && !empty($bInfo['admission_fees'])) {
                    $af = (float) $bInfo['admission_fees'];
                }
                if ($cd <= 0 && !empty($bInfo['caution_deposit'])) {
                    $cd = (float) $bInfo['caution_deposit'];
                }

                $formatFee = function($amount) {
                    $amount = (float) $amount;
                    if ($amount <= 0) return '0';
                    if ($amount >= 1000) {
                        if (fmod($amount, 1000) == 0) {
                            return ($amount / 1000) . 'k';
                        }
                        if (fmod($amount, 100) == 0) {
                            return rtrim(rtrim(number_format($amount / 1000, 2), '0'), '.') . 'k';
                        }
                        return number_format($amount);
                    }
                    return (string) (int) $amount;
                };

                $parts = [];
                if ($af > 0) {
                    $parts[] = 'AF ₹' . $formatFee($af);
                }
                if ($cd > 0) {
                    $parts[] = 'CD ₹' . $formatFee($cd);
                }

                if (!empty($parts)) {
                    $rentPriceSub = '(' . implode(' + ', $parts) . ')';
                } else {
                    $rentPriceSub = '';
                }

                // Dynamic Room Features from saiyoojyam_rooms.rooms_features & saiyoojyam_room_feature
                $features = [];
                if (!empty($r->rooms_features)) {
                    $rawFeatures = $r->rooms_features;
                    $featureIds = [];
                    if (is_string($rawFeatures) && (strpos($rawFeatures, '[') === 0 || strpos($rawFeatures, '{') === 0)) {
                        $decoded = json_decode($rawFeatures, true);
                        if (is_array($decoded)) {
                            $featureIds = $decoded;
                        }
                    }
                    if (empty($featureIds)) {
                        $featureIds = array_filter(array_map('trim', explode(',', (string) $rawFeatures)));
                    }

                    foreach ($featureIds as $fItem) {
                        if (is_numeric($fItem)) {
                            $fId = (int) $fItem;
                            if (isset($roomFeaturesMap[$fId])) {
                                $features[] = [
                                    'id'    => $fId,
                                    'name'  => $roomFeaturesMap[$fId]['name'],
                                    'icon'  => $roomFeaturesMap[$fId]['icon'],
                                    'image' => $roomFeaturesMap[$fId]['image'],
                                ];
                            }
                        } elseif (is_string($fItem) && !empty($fItem)) {
                            $found = false;
                            foreach ($roomFeaturesMap as $rf) {
                                if (strcasecmp($rf['name'], $fItem) === 0) {
                                    $features[] = [
                                        'id'    => $rf['id'],
                                        'name'  => $rf['name'],
                                        'icon'  => $rf['icon'],
                                        'image' => $rf['image'],
                                    ];
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $features[] = [
                                    'name' => $fItem,
                                    'icon' => $getFeatureIcon($fItem),
                                ];
                            }
                        }
                    }
                }

                // Fallback only if no dynamic features configured in database
                if (empty($features)) {
                    $features = [
                        ['name' => $isAc ? 'Split AC' : 'Ceiling Fan & Cross Vent', 'icon' => 'Wind'],
                        ['name' => 'Attached Bath', 'icon' => 'ShowerHead'],
                        ['name' => 'Homely Food & Tiffin', 'icon' => 'Utensils'],
                        ['name' => 'Inverter Wi-Fi', 'icon' => 'Wifi'],
                    ];
                    if ($isAc) {
                        $features[] = ['name' => 'Power Backup', 'icon' => 'Zap'];
                    }
                }

                $baseUrl = rtrim(base_url(), '/') . '/';
                $roomImage = '';
                if (!empty($r->rooms_image)) {
                    $roomImage = $baseUrl . 'public/uploads/rooms/' . $r->rooms_image;
                } elseif (!empty($bInfo['image'])) {
                    $roomImage = $bInfo['image'];
                }

                $roomDescription = !empty($r->rooms_description)
                    ? trim(strip_tags($r->rooms_description))
                    : "Comfortable {$capacity}-sharing accommodation in {$bInfo['name']} with homely meals, attached bathroom, purified drinking water, and high-speed Wi-Fi.";

                $formattedRooms[] = [
                    'id'                => 'room-' . $r->rooms_id,
                    'dbId'              => (int) $r->rooms_id,
                    'roomNumber'        => $r->rooms_name ?? ('Room ' . $r->rooms_id),
                    'apartmentName'     => strtoupper($bInfo['name']),
                    'buildingKey'       => $bKey,
                    'buildingId'        => $bInfo['id'],
                    'buildingName'      => $bInfo['name'],
                    'subHeaderLocation' => $bInfo['tagline'] ?: ($bInfo['name'] . ' • Kakkanad'),
                    'buildingAddress'   => $bInfo['address'] ?? '',
                    'building_address'  => $bInfo['address'] ?? '',
                    'address'           => $bInfo['address'] ?? '',
                    'title'             => !empty($typeName) && $typeName !== 'Standard Room'
                                            ? "{$typeName} ({$r->rooms_name})"
                                            : ($isAc ? "{$capacity}-Bed AC Room ({$r->rooms_name})" : "{$capacity}-Bed Room ({$r->rooms_name})"),
                    'roomType'          => (string) $capacity,
                    'roomTypeId'        => $rtInfo['id'],
                    'roomTypeName'      => $typeName,
                    'roomTypeSlug'      => $rtInfo['slug'] ?? '',
                    'rooms_capacity'    => (int) ($r->rooms_capacity ?? $capacity),
                    'roomsCapacity'     => (int) ($r->rooms_capacity ?? $capacity),
                    'capacity'          => (int) ($r->rooms_capacity ?? $capacity),
                    'badgeCategory'     => $badgeCategory,
                    'isAc'              => $isAc,
                    'floorLevel'        => 'LEVEL ' . (substr((string) ($r->rooms_name ?? '1'), 0, 1) ?: '1'),
                    'availableFromDate'    => $availableFromDate,
                    'availableFromDisplay' => $availableFromDisplay,
                    'isUpcomingVacancy'    => $isUpcomingVacancy,
                    'vacateDate'           => $vacateDate,
                    'bedsFreeText'         => $bedsFreeText,
                    'bedsFreeCount'        => $availableBeds,
                    'totalBeds'            => $capacity,
                    'occupiedBeds'         => max(0, $capacity - $availableBeds),
                    'bedLayoutIcons'    => array_fill(0, $capacity, 'single'),
                    'orientation'       => $capacity <= 2 ? 'East Facing' : 'Courtyard View',
                    'wingInfo'          => $bInfo['name'],
                    'levelTag'          => 'LEVEL ' . (substr((string) ($r->rooms_name ?? '1'), 0, 1) ?: '1'),
                    'features'          => $features,
                    'includesText'      => 'Includes 3 Homely Meals & 7:30 AM Tiffin • Daily Housekeeping',
                    'rentMonthly'           => number_format($rentPrice),
                    'rentPrice'             => (float) $rentPrice,
                    'rentPriceRaw'          => $rentPrice,
                    'tariffsPrice'          => (float) $rentPrice,
                    'totalPrice'            => (float) ($rentPrice + $af + $cd),
                    'totalRent'             => (float) ($rentPrice + $af + $cd),
                    'rentPriceTotal'        => (float) ($rentPrice + $af + $cd),
                    'rentPriceSub'          => $rentPriceSub,
                    'admissionFees'         => (float) $af,
                    'cautionDeposit'        => (float) $cd,
                    'tariffsAdmissionFees'  => (float) $af,
                    'tariffsCautionDeposit' => (float) $cd,
                    'description'           => $roomDescription,
                    'image'             => $roomImage,
                    'includedServices'  => [
                        'Homely 3 Meals & Tiffin',
                        'Daily Housekeeping',
                        'High Speed Wi-Fi',
                        '24/7 Security & RO Water'
                    ],
                    'whatsapp'          => $bInfo['whatsapp'],
                ];
            }
        }

        // Filtering
        $filtered = array_values(array_filter($formattedRooms, function ($room) use ($locationParam, $roomTypeParam, $filterParam) {
            // Location match
            if (!empty($locationParam) && $locationParam !== 'all') {
                $bKey = strtolower($room['buildingKey'] ?? '');
                $bName = strtolower($room['buildingName'] ?? '');
                $bId = (string)($room['buildingId'] ?? '');

                $matchesLocation = (
                    $bKey === $locationParam ||
                    $bId === $locationParam ||
                    $bName === $locationParam ||
                    stripos($bKey, $locationParam) !== false ||
                    stripos($locationParam, $bKey) !== false ||
                    stripos($bName, $locationParam) !== false ||
                    ($locationParam === 'annex' && stripos($bKey, 'annex') !== false) ||
                    ($locationParam === 'towers' && stripos($bKey, 'tower') !== false) ||
                    ($locationParam === 'premier' && stripos($bKey, 'premier') !== false)
                );

                if (!$matchesLocation) {
                    return false;
                }
            }

            // Room type / capacity match
            if (!empty($roomTypeParam) && $roomTypeParam !== 'all') {
                $targetShares = null;
                if (preg_match('/^(\d+)$/', $roomTypeParam, $sm)) {
                    $targetShares = (int) $sm[1];
                } elseif (preg_match('/(\d+)\s*(?:-|share|bed|sharing)/i', $roomTypeParam, $sm)) {
                    $targetShares = (int) $sm[1];
                } elseif (stripos($roomTypeParam, 'single') !== false) {
                    $targetShares = 1;
                }

                $matchesRoomType = (
                    $room['roomType'] === $roomTypeParam ||
                    (string)($room['roomTypeId'] ?? '') === (string)$roomTypeParam ||
                    (string)($room['capacity'] ?? '') === (string)$roomTypeParam ||
                    (isset($room['roomTypeSlug']) && (
                        strcasecmp($room['roomTypeSlug'], $roomTypeParam) === 0 ||
                        stripos($room['roomTypeSlug'], $roomTypeParam) !== false ||
                        stripos($roomTypeParam, $room['roomTypeSlug']) !== false
                    )) ||
                    (isset($room['roomTypeName']) && (
                        strcasecmp($room['roomTypeName'], $roomTypeParam) === 0 ||
                        stripos($room['roomTypeName'], $roomTypeParam) !== false
                    )) ||
                    ($targetShares !== null && (
                        (int)$room['capacity'] === $targetShares ||
                        (int)$room['roomType'] === $targetShares ||
                        (isset($room['shares']) && (int)$room['shares'] === $targetShares)
                    ))
                );
                if (!$matchesRoomType) {
                    return false;
                }
            }

            // Specific category filter match
            if (!empty($filterParam) && $filterParam !== 'all') {
                $fLower = strtolower($filterParam);
                if (strpos($fLower, 'premier-') === 0 && $room['buildingKey'] !== 'premier') return false;
                if (strpos($fLower, 'annex-') === 0 && $room['buildingKey'] !== 'annex') return false;
                if ((strpos($fLower, 't1-') === 0 || strpos($fLower, 't2-') === 0 || strpos($fLower, 'towers-') === 0) && $room['buildingKey'] !== 'towers') return false;

                if (strpos($fLower, 'nonac') !== false || strpos($fLower, 'non-ac') !== false) {
                    if ($room['isAc']) return false;
                } elseif (strpos($fLower, 'ac') !== false) {
                    if (!$room['isAc']) return false;
                }

                // Check sharing number in filter tag (e.g. "annex-2-ac" -> 2)
                if (preg_match('/-(\d+)-?/', $fLower, $m)) {
                    $shares = $m[1];
                    if ($room['roomType'] !== $shares) return false;
                }
            }

            return true;
        }));

        $buildingList = [];
        foreach ($buildingMap as $bInfo) {
            $buildingList[] = [
                'id'       => $bInfo['id'],
                'name'     => $bInfo['name'],
                'slug'     => $bInfo['slug'],
                'tagline'  => $bInfo['tagline'],
                'address'  => $bInfo['address'],
                'whatsapp' => $bInfo['whatsapp'],
            ];
        }

        $buildingCount = 0;
        if (!empty($locationParam) && $locationParam !== 'all') {
            foreach ($formattedRooms as $rm) {
                if ($rm['buildingKey'] === $locationParam || strtolower($rm['buildingName']) === $locationParam) {
                    $buildingCount++;
                }
            }
        }

        $tariffedRoomTypeIds = [];
        foreach ($formattedRooms as $frm) {
            if (!empty($frm['roomTypeId'])) {
                $tariffedRoomTypeIds[$frm['roomTypeId']] = true;
            }
        }

        $activeRoomTypes = array_values($roomTypeMap);

        $filteredBuildingCategories = $buildingCategories;

        return $this->response->setJSON([
            'status'             => true,
            'selected'           => [
                'location'  => $locationParam ?: 'all',
                'date'      => $checkInDate,
                'roomType'  => $roomTypeParam ?: 'all',
                'filter'    => $filterParam ?: null,
            ],
            'totalCount'         => count($formattedRooms),
            'buildingCount'      => $buildingCount,
            'count'              => count($filtered),
            'buildings'          => $buildingList,
            'buildingCategories' => $filteredBuildingCategories,
            'roomTypes'          => $activeRoomTypes,
            'data'               => $filtered,
            'allRooms'           => $formattedRooms,
        ]);
    }

    public function roomTypes()
    {
        $this->setCorsHeaders();

        $db = \Config\Database::connect();
        $roomTypes = [];
        if ($db->tableExists('saiyoojyam_room_type')) {
            $builder = $db->table('saiyoojyam_room_type');
            $builder->orderBy('room_type_name', 'ASC');
            $roomTypes = $builder->get()->getResult();
        }

        $formatted = [];
        foreach ($roomTypes as $rt) {
            $name = trim($rt->room_type_name ?? '');
            if (empty($name)) continue;
            $slug = trim($rt->room_type_slug ?? '');
            $bId = (int) ($rt->room_type_building_id ?? 0);

            $shares = 0;
            if (preg_match('/(\d+)\s*(?:share|bed|sharing)/i', $name, $m)) {
                $shares = (int) $m[1];
            } elseif (stripos($name, 'single') !== false) {
                $shares = 1;
            }

            $formatted[] = [
                'id'             => (int) $rt->room_type_id,
                'value'          => $slug ?: (string) $rt->room_type_id,
                'label'          => $name,
                'name'           => $name,
                'slug'           => $slug,
                'shares'         => $shares,
                'building_id'    => $bId,
                'room_type_name' => $name,
            ];
        }

        return $this->response->setJSON([
            'status' => true,
            'count'  => count($formatted),
            'data'   => $formatted,
        ]);
    }

    /**
     * Check Room Availability for Selected Check-In and Check-Out Dates
     * GET /api/rooms/check-availability
     * POST /api/rooms/check-availability
     */
    public function checkAvailability()
    {
        $this->setCorsHeaders();
        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($input)) {
            $input = $this->request->getGet();
        }

        $db = \Config\Database::connect();

        $rawRoomId = $input['room_id'] ?? $input['roomId'] ?? $input['room'] ?? '';
        $cleanRoomId = (int) preg_replace('/[^\d]/', '', (string) $rawRoomId);
        $checkIn = trim((string) ($input['check_in'] ?? $input['checkIn'] ?? ''));
        $checkOut = trim((string) ($input['check_out'] ?? $input['checkOut'] ?? ''));
        $duration = trim((string) ($input['duration'] ?? 'Long Term'));
        $buildingParam = trim((string) ($input['building'] ?? $input['building_id'] ?? ''));

        if (empty($checkIn)) {
            $checkIn = date('Y-m-d');
        }

        $checkInDate = date('Y-m-d', strtotime($checkIn));

        if (!empty($checkOut) && $checkOut !== '0000-00-00') {
            $checkOutDate = date('Y-m-d', strtotime($checkOut));
        } else {
            $checkOutDate = '9999-12-31';
        }

        if ($checkOutDate <= $checkInDate && $checkOutDate !== '9999-12-31') {
            return $this->response->setStatusCode(400)->setJSON([
                'status'       => false,
                'is_available' => false,
                'message'      => 'Check-out date must be after check-in date.',
            ]);
        }

        // If specific room requested
        if ($cleanRoomId > 0 && $db->tableExists('saiyoojyam_rooms')) {
            $room = $db->table('saiyoojyam_rooms')->where('rooms_id', $cleanRoomId)->get()->getRow();
            if (!$room) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status'       => false,
                    'is_available' => false,
                    'message'      => 'Selected room was not found.',
                ]);
            }

            if ($room->rooms_status === 'maintenance') {
                return $this->response->setJSON([
                    'status'         => true,
                    'is_available'   => false,
                    'room_id'        => (int) $room->rooms_id,
                    'room_name'      => $room->rooms_name,
                    'capacity'       => (int) $room->rooms_capacity,
                    'occupied'       => (int) $room->rooms_capacity,
                    'available_beds' => 0,
                    'status_label'   => 'Under Maintenance',
                    'message'        => 'Room ' . $room->rooms_name . ' is currently undergoing maintenance and is not available.',
                ]);
            }

            $capacity = (int) $room->rooms_capacity;
            $isShortTerm = ($duration === 'Short Term' && !empty($checkOut) && $checkOut !== '0000-00-00' && $checkOutDate !== '9999-12-31');

            $inmates = $db->table('saiyoojyam_inmates')
                ->where('inmates_rooms', (int) $room->rooms_id)
                ->whereNotIn('inmates_status', ['checked_out', 'checkout', 'rejected', 'cancelled', 'inactive'])
                ->get()
                ->getResult();

            $getOccOnDate = function($targetDate) use ($inmates) {
                $cnt = 0;
                foreach ($inmates as $inm) {
                    $cIn = $inm->inmates_check_in_date ?? '';
                    $cOut = $inm->inmates_check_out_date ?? '';
                    if (!empty($cIn) && $cIn <= $targetDate) {
                        if (empty($cOut) || $cOut === '0000-00-00' || $cOut > $targetDate) {
                            $cnt++;
                        }
                    }
                }
                return $cnt;
            };

            if ($isShortTerm) {
                $maxOccupied = 0;
                $firstFullDate = null;
                $startTs = strtotime($checkInDate);
                $endTs = strtotime($checkOutDate);
                $diffDays = min(365, max(1, (int) round(($endTs - $startTs) / 86400)));
                for ($i = 0; $i < $diffDays; $i++) {
                    $curDay = date('Y-m-d', strtotime("+$i day", $startTs));
                    $dayOcc = $getOccOnDate($curDay);
                    if ($dayOcc > $maxOccupied) {
                        $maxOccupied = $dayOcc;
                    }
                    if ($dayOcc >= $capacity && $firstFullDate === null) {
                        $firstFullDate = $curDay;
                    }
                }
                $occupiedCount = $maxOccupied;
                $availableBeds = max(0, $capacity - $maxOccupied);
                $isAvailable = ($availableBeds > 0);

                $message = $isAvailable
                    ? 'Room ' . $room->rooms_name . ' is available (' . $availableBeds . ' bed' . ($availableBeds > 1 ? 's' : '') . ' free) for your selected dates.'
                    : 'Room ' . $room->rooms_name . ' is not available for the selected dates. All ' . $capacity . ' beds are fully booked' . ($firstFullDate ? ' starting ' . date('M j, Y', strtotime($firstFullDate)) : '') . '.';
            } else {
                // Long Term stay: An ongoing, continuous monthly stay starting from $checkInDate.
                // A room is only available for Long Term if a bed remains available continuously.
                // If on ANY date starting from $checkInDate, all beds are occupied (occupied >= capacity),
                // then the room is NOT available for Long Term.
                $checkDates = [];
                $startTs = strtotime($checkInDate);
                for ($d = 0; $d <= 90; $d++) {
                    $checkDates[] = date('Y-m-d', strtotime("+$d day", $startTs));
                }
                foreach ($inmates as $inm) {
                    $cIn = $inm->inmates_check_in_date ?? '';
                    if (!empty($cIn) && $cIn >= $checkInDate) {
                        $checkDates[] = $cIn;
                    }
                }
                $checkDates = array_unique($checkDates);
                sort($checkDates);

                $maxFutureOccupied = 0;
                $firstFullDate = null;
                $lastFreeDate = null;

                foreach ($checkDates as $cDate) {
                    $dayOcc = $getOccOnDate($cDate);
                    if ($dayOcc > $maxFutureOccupied) {
                        $maxFutureOccupied = $dayOcc;
                    }
                    if ($dayOcc >= $capacity) {
                        if ($firstFullDate === null) {
                            $firstFullDate = $cDate;
                        }
                    } else {
                        if ($firstFullDate === null) {
                            $lastFreeDate = $cDate;
                        }
                    }
                }

                $occupiedCount = $maxFutureOccupied;
                $availableBeds = max(0, $capacity - $maxFutureOccupied);
                $isAvailable = ($availableBeds > 0);

                if ($isAvailable) {
                    $message = 'Room ' . $room->rooms_name . ' is available (' . $availableBeds . ' bed' . ($availableBeds > 1 ? 's' : '') . ' free) for Long Term stay.';
                } else {
                    if ($firstFullDate) {
                        $fullFormatted = date('M j, Y', strtotime($firstFullDate));
                        $freeUntilFormatted = $lastFreeDate ? date('M j, Y', strtotime($lastFreeDate)) : null;
                        if ($freeUntilFormatted && $freeUntilFormatted !== date('M j, Y', strtotime($checkInDate))) {
                            $message = 'Room ' . $room->rooms_name . ' is not available for Long Term stay. Beds are only free from ' . date('M j, Y', strtotime($checkInDate)) . ' until ' . $freeUntilFormatted . ', and fully booked starting ' . $fullFormatted . '. Only Short Term stays up to ' . $freeUntilFormatted . ' are possible.';
                        } else {
                            $message = 'Room ' . $room->rooms_name . ' is not available for Long Term stay because all beds are fully booked starting ' . $fullFormatted . '.';
                        }
                    } else {
                        $message = 'Room ' . $room->rooms_name . ' is not available for Long Term stay. All ' . $capacity . ' beds are fully booked.';
                    }
                }
            }

            return $this->response->setJSON([
                'status'         => true,
                'is_available'   => $isAvailable,
                'room_id'        => (int) $room->rooms_id,
                'room_name'      => $room->rooms_name,
                'capacity'       => $capacity,
                'occupied'       => $occupiedCount,
                'available_beds' => $availableBeds,
                'status_label'   => $isAvailable ? 'Available' : 'Fully Booked',
                'message'        => $message,
            ]);
        }

        // If no specific room, but building specified
        $buildingId = 0;
        if (is_numeric($buildingParam) && (int) $buildingParam > 0) {
            $buildingId = (int) $buildingParam;
        } elseif (!empty($buildingParam) && $db->tableExists('saiyoojyam_building')) {
            $bSlugClean = strtolower(trim($buildingParam));
            $bRow = $db->table('saiyoojyam_building')
                ->where('LOWER(building_slug)', $bSlugClean)
                ->orWhere('building_slug', 'saiyoojyam-' . $bSlugClean)
                ->orLike('LOWER(building_name)', $bSlugClean)
                ->get()
                ->getRow();
            if ($bRow) {
                $buildingId = (int) $bRow->building_id;
            }
        }

        $roomsQuery = $db->table('saiyoojyam_rooms');
        if ($buildingId > 0) {
            $roomsQuery->where('rooms_building', $buildingId);
        }
        $rooms = $roomsQuery->get()->getResult();

        $totalCapacity = 0;
        $totalOccupied = 0;
        $availableRoomsList = [];
        $isShortTerm = ($duration === 'Short Term' && !empty($checkOut) && $checkOut !== '0000-00-00' && $checkOutDate !== '9999-12-31');

        foreach ($rooms as $r) {
            if ($r->rooms_status === 'maintenance') continue;
            $cap = (int) $r->rooms_capacity;
            $totalCapacity += $cap;

            $rInmates = $db->table('saiyoojyam_inmates')
                ->where('inmates_rooms', (int) $r->rooms_id)
                ->whereNotIn('inmates_status', ['checked_out', 'checkout', 'rejected', 'cancelled', 'inactive'])
                ->get()
                ->getResult();

            if ($isShortTerm) {
                $maxOcc = 0;
                $startTs = strtotime($checkInDate);
                $endTs = strtotime($checkOutDate);
                $diffDays = min(365, max(1, (int) round(($endTs - $startTs) / 86400)));
                for ($i = 0; $i < $diffDays; $i++) {
                    $curDay = date('Y-m-d', strtotime("+$i day", $startTs));
                    $dayOcc = 0;
                    foreach ($rInmates as $inm) {
                        $cIn = $inm->inmates_check_in_date ?? '';
                        $cOut = $inm->inmates_check_out_date ?? '';
                        if (!empty($cIn) && $cIn <= $curDay) {
                            if (empty($cOut) || $cOut === '0000-00-00' || $cOut > $curDay) {
                                $dayOcc++;
                            }
                        }
                    }
                    if ($dayOcc > $maxOcc) $maxOcc = $dayOcc;
                }
                $occ = $maxOcc;
            } else {
                $checkDates = [];
                $startTs = strtotime($checkInDate);
                for ($d = 0; $d <= 90; $d++) {
                    $checkDates[] = date('Y-m-d', strtotime("+$d day", $startTs));
                }
                foreach ($rInmates as $inm) {
                    $cIn = $inm->inmates_check_in_date ?? '';
                    if (!empty($cIn) && $cIn >= $checkInDate) {
                        $checkDates[] = $cIn;
                    }
                }
                $checkDates = array_unique($checkDates);
                sort($checkDates);

                $maxFutureOcc = 0;
                foreach ($checkDates as $cDate) {
                    $dayOcc = 0;
                    foreach ($rInmates as $inm) {
                        $cIn = $inm->inmates_check_in_date ?? '';
                        $cOut = $inm->inmates_check_out_date ?? '';
                        if (!empty($cIn) && $cIn <= $cDate) {
                            if (empty($cOut) || $cOut === '0000-00-00' || $cOut > $cDate) {
                                $dayOcc++;
                            }
                        }
                    }
                    if ($dayOcc > $maxFutureOcc) {
                        $maxFutureOcc = $dayOcc;
                    }
                }
                $occ = $maxFutureOcc;
            }

            $totalOccupied += $occ;
            $free = max(0, $cap - $occ);
            if ($free > 0) {
                $availableRoomsList[] = [
                    'room_id'        => (int) $r->rooms_id,
                    'room_name'      => $r->rooms_name,
                    'available_beds' => $free,
                ];
            }
        }

        $totalAvailableBeds = max(0, $totalCapacity - $totalOccupied);
        $isAvailable = ($totalAvailableBeds > 0);

        return $this->response->setJSON([
            'status'               => true,
            'is_available'         => $isAvailable,
            'total_capacity'       => $totalCapacity,
            'total_occupied'       => $totalOccupied,
            'total_available_beds' => $totalAvailableBeds,
            'available_rooms_count'=> count($availableRoomsList),
            'available_rooms'      => $availableRoomsList,
            'status_label'         => $isAvailable ? 'Available' : 'Fully Booked',
            'message'              => $isAvailable
                ? count($availableRoomsList) . ' room(s) with ' . $totalAvailableBeds . ' bed(s) available for the selected dates.'
                : 'No rooms available for the selected dates.',
        ]);
    }
}
