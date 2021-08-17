<?php

use App\Models\Origin;
use Illuminate\Database\Seeder;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Origin::count() == 0) {
            $origins = [
                /*'Afghanistan', 'Åland Islands', 'Albania', 'Algeria', 'American Samoa',
                'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua and Barbuda',
                'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan',

                'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium',
                'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina',
                'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory',
                'British Virgin Islands', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi',

                'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Caribbean Netherlands',
                'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China',
                'Christmas Island', 'Cocos [Keeling] Islands', 'Colombia', 'Comoros',
                'Congo - Brazzaville', 'Congo - Kinshasa', 'Cook Islands', 'Costa Rica',
                'Côte d’Ivoire', 'Croatia', 'Cuba', 'Curaçao', 'Cyprus', 'Czech Republic',

                'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',

                'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea',
                'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands',

                'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia',
                'French Southern Territories',

                'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece',
                'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey',
                'Guinea', 'Guinea-Bissau', 'Guyana',

                'Haiti', 'Heard Island and McDonald Islands', 'Honduras',
                'Hong Kong SAR China', 'Hungary',

                'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland',
                'Isle of Man', 'Israel', 'Italy',

                'Jamaica', 'Japan', 'Jersey', 'Jordan',

                'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan',

                'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya',
                'Liechtenstein', 'Lithuania', 'Luxembourg',

                'Macau SAR China', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia',
                'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique',
                'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldova',
                'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique',
                'Myanmar [Burma]',

                'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles',
                'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue',
                'Norfolk Island', 'Northern Mariana Islands', 'North Korea', 'Norway',

                'Oman',

                'Pakistan', 'Palau', 'Palestinian Territories', 'Panama', 'Papua New Guinea',
                'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal',

                'Qatar',

                'Réunion', 'Romania', 'Russia', 'Rwanda',

                'Saint Barthélemy', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia',
                'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines',
                'Samoa', 'San Marino', 'São Tomé and Príncipe', 'Saudi Arabia', 'Senegal',
                'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten',
                'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa',
                'South Georgia and the South Sandwich Islands', 'South Korea', 'Spain', 'Sri Lanka',
                'Sudan', 'Suriname', 'Svalbard and Jan Mayen', 'Swaziland', 'Sweden', 'Switzerland',
                'Syria',

                'Taiwan, Province of China', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste',
                'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan',
                'Turks and Caicos Islands', 'Tuvalu',

                'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States',
                'Uruguay', 'U.S. Outlying Islands', 'U.S. Virgin Islands', 'Uzbekistan',

                'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam',

                'Wallis and Futuna', 'Western Sahara',

                'Yemen',

                'Zambia', 'Zimbabwe'*/

                'Brazil', 'Colombia', 'Rwanda', 'Ethiopia', 'Various', 'Kenya',
                'Burundi', 'Costa Rica', 'Guatemala', 'El Salvador', 'Panama',
            ];

            foreach ($origins as $key => $level) {
                Origin::create([
                    'origin_name' => $level,
                    'display_order' => ($key + 1),
                    'status' => 1
                ]);
            }
        }
    }
}
