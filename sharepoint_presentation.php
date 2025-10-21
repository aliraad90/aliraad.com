<?php
// SharePoint Document Control System Presentation
// Iraq Power Plants: Kharblaa, Najaf, Al-Kharkh

// Configuration
$presentation_config = [
    'title' => 'SharePoint Document Control System',
    'subtitle' => 'Iraq Power Plants - Centralized Document Management',
    'presenter' => 'Senior Document Controller',
    'company' => 'Siemens Energy - Iraq Power Generation Projects',
    'plants' => ['Kharblaa', 'Najaf', 'Al-Kharkh'],
    'colors' => [
        'primary' => '#5E2584',
        'secondary' => '#0097A9',
        'light' => '#F3F3F3',
        'success' => '#28a745',
        'warning' => '#ffc107'
    ]
];

// KPI Data
$kpi_data = [
    ['number' => '247', 'label' => 'Total Documents', 'icon' => '📄'],
    ['number' => '15', 'label' => 'Pending Approvals', 'icon' => '⏳'],
    ['number' => '32', 'label' => 'Approved This Month', 'icon' => '✅'],
    ['number' => '98%', 'label' => 'Compliance Rate', 'icon' => '📊'],
    ['number' => '5.2', 'label' => 'Avg. Approval Days', 'icon' => '⏱️'],
    ['number' => '156', 'label' => 'Archived Documents', 'icon' => '📦']
];

// Document Categories
$document_categories = [
    ['name' => 'Engineering', 'icon' => '📋', 'count' => 89],
    ['name' => 'QA/QC', 'icon' => '✅', 'count' => 67],
    ['name' => 'Operations', 'icon' => '📖', 'count' => 45],
    ['name' => 'Contracts', 'icon' => '📄', 'count' => 23],
    ['name' => 'Maintenance', 'icon' => '🔧', 'count' => 23]
];

// Workflow Steps
$workflow_steps = [
    ['title' => 'Document Upload', 'description' => 'User uploads document with metadata', 'icon' => '📤'],
    ['title' => 'Manager Review', 'description' => 'Automatic routing to plant manager', 'icon' => '👨‍💼'],
    ['title' => 'Status Update', 'description' => 'Document marked as approved', 'icon' => '✅'],
    ['title' => 'Auto Archive', 'description' => 'Old versions moved to archive', 'icon' => '📦'],
    ['title' => 'Notifications', 'description' => 'Stakeholders receive updates', 'icon' => '📧']
];

// Implementation Timeline
$timeline = [
    ['phase' => 1, 'title' => 'Foundation Setup', 'duration' => 'Week 1-2', 'description' => 'Create main SharePoint site, configure basic structure, set up document libraries for each plant'],
    ['phase' => 2, 'title' => 'Metadata & Permissions', 'duration' => 'Week 3', 'description' => 'Configure metadata columns, set up user groups and permissions, create custom views'],
    ['phase' => 3, 'title' => 'Workflow Automation', 'duration' => 'Week 4-5', 'description' => 'Implement Power Automate workflows for approval processes, notifications, and archiving'],
    ['phase' => 4, 'title' => 'Dashboard & Reporting', 'duration' => 'Week 6', 'description' => 'Set up Power BI dashboard, configure KPI tracking, create management reports'],
    ['phase' => 5, 'title' => 'Testing & Training', 'duration' => 'Week 7-8', 'description' => 'User acceptance testing, staff training sessions, documentation and go-live support']
];

// Benefits Data
$benefits = [
    ['title' => 'Time Savings', 'description' => '75% reduction in document search time through centralized storage and advanced search capabilities', 'icon' => '⏱️', 'metric' => '75%'],
    ['title' => 'Improved Accuracy', 'description' => '90% reduction in errors from outdated documents through automated version control', 'icon' => '🎯', 'metric' => '90%'],
    ['title' => 'Enhanced Compliance', 'description' => '100% audit trail for all document activities, ensuring regulatory compliance', 'icon' => '📈', 'metric' => '100%'],
    ['title' => 'Better Collaboration', 'description' => 'Real-time collaboration across all three plants with consistent processes', 'icon' => '🤝', 'metric' => 'Real-time'],
    ['title' => 'Cost Reduction', 'description' => '60% reduction in administrative overhead through automation', 'icon' => '💰', 'metric' => '60%'],
    ['title' => 'Scalability', 'description' => 'Easy expansion to additional plants or projects with proven framework', 'icon' => '🔄', 'metric' => 'Unlimited']
];

// Get current slide from URL parameter
$current_slide = isset($_GET['slide']) ? (int)$_GET['slide'] : 1;
$total_slides = 10;

// Function to generate navigation
function generateNavigation($current, $total) {
    $nav = '<div class="navigation">';
    
    // Previous button
    if ($current > 1) {
        $nav .= '<a href="?slide=' . ($current - 1) . '" class="nav-btn prev">← Previous</a>';
    }
    
    // Slide indicator
    $nav .= '<div class="slide-indicator">';
    for ($i = 1; $i <= $total; $i++) {
        $active = ($i == $current) ? 'active' : '';
        $nav .= '<a href="?slide=' . $i . '" class="slide-dot ' . $active . '">' . $i . '</a>';
    }
    $nav .= '</div>';
    
    // Next button
    if ($current < $total) {
        $nav .= '<a href="?slide=' . ($current + 1) . '" class="nav-btn next">Next →</a>';
    }
    
    $nav .= '</div>';
    return $nav;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $presentation_config['title']; ?> - Slide <?php echo $current_slide; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .slide {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 50px;
            margin-bottom: 30px;
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .slide-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .slide-title {
            color: <?php echo $presentation_config['colors']['primary']; ?>;
            font-size: 2.8em;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 4px solid <?php echo $presentation_config['colors']['secondary']; ?>;
            padding-bottom: 15px;
            display: inline-block;
        }

        .slide-subtitle {
            color: <?php echo $presentation_config['colors']['secondary']; ?>;
            font-size: 1.4em;
            margin-bottom: 20px;
        }

        .main-hub {
            background: linear-gradient(135deg, <?php echo $presentation_config['colors']['primary']; ?>, #7B3FA0);
            color: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin: 30px auto;
            max-width: 600px;
            box-shadow: 0 8px 25px rgba(94, 37, 132, 0.3);
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .main-hub:hover {
            transform: translateY(-5px);
        }

        .plants-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin: 40px 0;
        }

        .plant-box {
            background: linear-gradient(135deg, <?php echo $presentation_config['colors']['secondary']; ?>, #00B4CC);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 151, 169, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .plant-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 151, 169, 0.4);
        }

        .plant-title {
            font-size: 1.5em;
            margin-bottom: 20px;
            border-bottom: 2px solid rgba(255,255,255,0.3);
            padding-bottom: 10px;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
            margin-top: 20px;
        }

        .category-item {
            background: rgba(255,255,255,0.2);
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9em;
            backdrop-filter: blur(10px);
            transition: background 0.3s ease;
        }

        .category-item:hover {
            background: rgba(255,255,255,0.3);
        }

        .workflow-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }

        .workflow-step {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
        }

        .workflow-step:hover {
            transform: translateY(-5px);
            border-color: <?php echo $presentation_config['colors']['secondary']; ?>;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .workflow-icon {
            font-size: 2.5em;
            margin-bottom: 15px;
            display: block;
        }

        .workflow-title {
            color: <?php echo $presentation_config['colors']['primary']; ?>;
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .kpi-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            border-left: 4px solid <?php echo $presentation_config['colors']['secondary']; ?>;
            transition: transform 0.3s ease;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
        }

        .kpi-number {
            font-size: 2.5em;
            font-weight: bold;
            color: <?php echo $presentation_config['colors']['secondary']; ?>;
            margin-bottom: 5px;
        }

        .kpi-label {
            color: #666;
            font-size: 0.9em;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .benefit-card {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 30px;
            border-radius: 12px;
            border-left: 5px solid <?php echo $presentation_config['colors']['secondary']; ?>;
            transition: all 0.3s ease;
        }

        .benefit-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .benefit-title {
            color: <?php echo $presentation_config['colors']['primary']; ?>;
            font-size: 1.3em;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .benefit-metric {
            background: <?php echo $presentation_config['colors']['secondary']; ?>;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .timeline {
            margin: 30px 0;
        }

        .timeline-item {
            display: flex;
            align-items: flex-start;
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid <?php echo $presentation_config['colors']['primary']; ?>;
            transition: all 0.3s ease;
        }

        .timeline-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .timeline-number {
            background: <?php echo $presentation_config['colors']['primary']; ?>;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-weight: bold;
            font-size: 1.2em;
            flex-shrink: 0;
        }

        .timeline-content h4 {
            color: <?php echo $presentation_config['colors']['primary']; ?>;
            margin-bottom: 5px;
        }

        .timeline-duration {
            color: <?php echo $presentation_config['colors']['secondary']; ?>;
            font-weight: bold;
            font-size: 0.9em;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            margin-top: 30px;
        }

        .nav-btn {
            background: <?php echo $presentation_config['colors']['primary']; ?>;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(94, 37, 132, 0.3);
        }

        .nav-btn:hover {
            background: #7B3FA0;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(94, 37, 132, 0.4);
        }

        .slide-indicator {
            display: flex;
            gap: 10px;
        }

        .slide-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #666;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .slide-dot.active {
            background: <?php echo $presentation_config['colors']['secondary']; ?>;
            color: white;
        }

        .slide-dot:hover {
            background: <?php echo $presentation_config['colors']['primary']; ?>;
            color: white;
        }

        .highlight-box {
            background: linear-gradient(135deg, #e8f4f8, #f0f8ff);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            margin: 30px 0;
            border: 2px solid <?php echo $presentation_config['colors']['secondary']; ?>;
        }

        .cta-box {
            background: linear-gradient(135deg, <?php echo $presentation_config['colors']['primary']; ?>, #7B3FA0);
            color: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            margin: 40px 0;
            box-shadow: 0 10px 30px rgba(94, 37, 132, 0.3);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .table th {
            background: <?php echo $presentation_config['colors']['primary']; ?>;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .table tr:hover {
            background: #e8f4f8;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin: 30px 0;
        }

        .contact-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .contact-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            border-top: 4px solid <?php echo $presentation_config['colors']['secondary']; ?>;
        }

        .contact-card h4 {
            color: <?php echo $presentation_config['colors']['primary']; ?>;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .slide {
                padding: 30px 20px;
            }
            
            .slide-title {
                font-size: 2em;
            }
            
            .plants-container,
            .workflow-container,
            .benefits-grid {
                grid-template-columns: 1fr;
            }
            
            .two-column {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .navigation {
                flex-direction: column;
                gap: 20px;
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: <?php echo $presentation_config['colors']['secondary']; ?>;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0, 151, 169, 0.3);
            z-index: 1000;
        }

        .print-btn:hover {
            background: #00B4CC;
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Print</button>
    
    <div class="container">
        <div class="slide fade-in">
            <?php
            switch($current_slide) {
                case 1:
                    // Title Slide
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title"><?php echo $presentation_config['title']; ?></h1>
                        <p class="slide-subtitle"><?php echo $presentation_config['subtitle']; ?></p>
                    </div>
                    
                    <div class="main-hub">
                        <h2 style="font-size: 2em; margin-bottom: 15px;">🏭 Three Power Plants</h2>
                        <p style="font-size: 1.3em;"><?php echo implode(' • ', $presentation_config['plants']); ?></p>
                    </div>
                    
                    <div style="text-align: center; margin-top: 50px;">
                        <p style="font-size: 1.2em; margin-bottom: 10px;"><strong>Presented by:</strong> <?php echo $presentation_config['presenter']; ?></p>
                        <p style="font-size: 1.1em; color: #666;"><?php echo $presentation_config['company']; ?></p>
                    </div>
                    <?php
                    break;

                case 2:
                    // System Architecture
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">System Architecture Overview</h1>
                    </div>
                    
                    <div class="main-hub">
                        <h2 style="font-size: 1.8em; margin-bottom: 10px;">📁 Main SharePoint Hub</h2>
                        <p style="font-size: 1.2em;">"Iraq Power Plants – Document Control"</p>
                    </div>
                    
                    <div class="plants-container">
                        <?php foreach($presentation_config['plants'] as $plant): ?>
                        <div class="plant-box">
                            <h3 class="plant-title">🏭 <?php echo $plant; ?> Power Plant</h3>
                            <div class="categories-grid">
                                <?php foreach($document_categories as $category): ?>
                                <div class="category-item">
                                    <?php echo $category['icon']; ?> <?php echo $category['name']; ?>
                                    <br><small>(<?php echo $category['count']; ?> docs)</small>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                    break;

                case 3:
                    // Workflow Process
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">Automated Workflow Process</h1>
                        <p class="slide-subtitle">📋 Power Automate Integration</p>
                    </div>
                    
                    <div class="workflow-container">
                        <?php foreach($workflow_steps as $index => $step): ?>
                        <div class="workflow-step">
                            <span class="workflow-icon"><?php echo $step['icon']; ?></span>
                            <h4 class="workflow-title"><?php echo $step['title']; ?></h4>
                            <p><?php echo $step['description']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="highlight-box">
                        <h3 style="color: <?php echo $presentation_config['colors']['primary']; ?>;">🔄 Automated Process Benefits</h3>
                        <p>Reduces manual work by 80% and ensures consistent document handling across all three power plants.</p>
                    </div>
                    <?php
                    break;

                case 4:
                    // Metadata Structure
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">Document Metadata Structure</h1>
                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field Name</th>
                                <th>Type</th>
                                <th>Options/Format</th>
                                <th>Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Plant Name</strong></td>
                                <td>Dropdown</td>
                                <td><?php echo implode(' / ', $presentation_config['plants']); ?></td>
                                <td>Identify source plant</td>
                            </tr>
                            <tr>
                                <td><strong>Document Type</strong></td>
                                <td>Choice</td>
                                <td>Engineering / QA-QC / Operations / Contracts / Maintenance</td>
                                <td>Categorize document</td>
                            </tr>
                            <tr>
                                <td><strong>Revision Number</strong></td>
                                <td>Text</td>
                                <td>Rev 01, Rev 02, etc.</td>
                                <td>Version control</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>Choice</td>
                                <td>Draft / Under Review / Approved / Archived</td>
                                <td>Track approval status</td>
                            </tr>
                            <tr>
                                <td><strong>Owner</strong></td>
                                <td>Person</td>
                                <td>SharePoint user</td>
                                <td>Responsible person</td>
                            </tr>
                            <tr>
                                <td><strong>Date Issued</strong></td>
                                <td>Date</td>
                                <td>DD/MM/YYYY</td>
                                <td>Track creation date</td>
                            </tr>
                            <tr>
                                <td><strong>Project Code</strong></td>
                                <td>Text</td>
                                <td>Plant-specific codes</td>
                                <td>Link to project</td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    break;

                case 5:
                    // KPI Dashboard
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">Management Dashboard & KPIs</h1>
                    </div>
                    
                    <div class="highlight-box">
                        <h3 style="color: <?php echo $presentation_config['colors']['primary']; ?>;">📊 Real-time Document Control Metrics</h3>
                        <p>Live data from all three power plants updated every 15 minutes</p>
                    </div>
                    
                    <div class="kpi-grid">
                        <?php foreach($kpi_data as $kpi): ?>
                        <div class="kpi-card">
                            <div style="font-size: 1.5em; margin-bottom: 10px;"><?php echo $kpi['icon']; ?></div>
                            <div class="kpi-number"><?php echo $kpi['number']; ?></div>
                            <div class="kpi-label"><?php echo $kpi['label']; ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div style="margin-top: 40px;">
                        <h3 style="color: <?php echo $presentation_config['colors']['primary']; ?>; margin-bottom: 20px;">📈 Power BI Integration Features:</h3>
                        <ul style="font-size: 1.1em; line-height: 1.8; columns: 2; column-gap: 40px;">
                            <li>Real-time document status tracking across all three plants</li>
                            <li>Approval bottleneck identification and resolution</li>
                            <li>Compliance reporting for audit purposes</li>
                            <li>Document lifecycle analytics and trends</li>
                            <li>Plant-specific performance comparisons</li>
                            <li>Automated alerts for overdue documents</li>
                        </ul>
                    </div>
                    <?php
                    break;

                case 6:
                    // Security & Access Control
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">Security & Access Control</h1>
                    </div>
                    
                    <div class="benefits-grid">
                        <div class="benefit-card">
                            <h4 class="benefit-title">🔐 Role-Based Access</h4>
                            <ul>
                                <li><strong>Site Owners:</strong> Full control (Document Controllers + Management)</li>
                                <li><strong>Plant Engineers:</strong> Edit access to their plant's documents</li>
                                <li><strong>Reviewers:</strong> Approval rights for specific document types</li>
                                <li><strong>Viewers:</strong> Read-only access to approved documents</li>
                            </ul>
                        </div>
                        
                        <div class="benefit-card">
                            <h4 class="benefit-title">📋 Audit Trail</h4>
                            <ul>
                                <li>Complete version history tracking</li>
                                <li>User activity logs and timestamps</li>
                                <li>Document access and download records</li>
                                <li>Approval workflow history</li>
                            </ul>
                        </div>
                        
                        <div class="benefit-card">
                            <h4 class="benefit-title">🛡️ Data Protection</h4>
                            <ul>
                                <li>SharePoint enterprise-grade security</li>
                                <li>Automatic backup and recovery</li>
                                <li>Compliance with Siemens Energy policies</li>
                                <li>Encrypted data transmission and storage</li>
                            </ul>
                        </div>
                        
                        <div class="benefit-card">
                            <h4 class="benefit-title">🔍 Advanced Search</h4>
                            <ul>
                                <li>Global search across all plants</li>
                                <li>Metadata-based filtering</li>
                                <li>Full-text content search</li>
                                <li>Saved search queries and alerts</li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    break;

                case 7:
                    // Implementation Timeline
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">Implementation Roadmap</h1>
                        <p class="slide-subtitle">📅 Phased Implementation Approach</p>
                    </div>
                    
                    <div class="timeline">
                        <?php foreach($timeline as $item): ?>
                        <div class="timeline-item">
                            <div class="timeline-number"><?php echo $item['phase']; ?></div>
                            <div class="timeline-content">
                                <h4>Phase <?php echo $item['phase']; ?>: <?php echo $item['title']; ?> <span class="timeline-duration">(<?php echo $item['duration']; ?>)</span></h4>
                                <p><?php echo $item['description']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="highlight-box">
                        <h3 style="color: <?php echo $presentation_config['colors']['primary']; ?>;">⏱️ Total Implementation Time: 8 Weeks</h3>
                        <p>Parallel execution of phases where possible to minimize disruption</p>
                    </div>
                    <?php
                    break;

                case 8:
                    // Business Benefits & ROI
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">Business Benefits & ROI</h1>
                    </div>
                    
                    <div class="benefits-grid">
                        <?php foreach($benefits as $benefit): ?>
                        <div class="benefit-card">
                            <h4 class="benefit-title">
                                <?php echo $benefit['icon']; ?> <?php echo $benefit['title']; ?>
                                <span class="benefit-metric"><?php echo $benefit['metric']; ?></span>
                            </h4>
                            <p><?php echo $benefit['description']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="cta-box">
                        <h3 style="margin-bottom: 15px;">💡 Expected ROI: 300% within 12 months</h3>
                        <p style="font-size: 1.2em;">Through reduced administrative costs, improved efficiency, and enhanced compliance across all three power plants</p>
                    </div>
                    <?php
                    break;

                case 9:
                    // Next Steps
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">Next Steps & Recommendations</h1>
                    </div>
                    
                    <div class="two-column">
                        <div>
                            <h3 style="color: <?php echo $presentation_config['colors']['primary']; ?>; margin-bottom: 25px;">🚀 Immediate Actions</h3>
                            <div class="timeline-item">
                                <div class="timeline-number">1</div>
                                <div>
                                    <h4>Management Approval</h4>
                                    <p>Secure management buy-in and budget allocation</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-number">2</div>
                                <div>
                                    <h4>IT Coordination</h4>
                                    <p>Coordinate with IT for SharePoint site creation and permissions</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-number">3</div>
                                <div>
                                    <h4>Stakeholder Engagement</h4>
                                    <p>Identify key users from each plant for requirements gathering</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 style="color: <?php echo $presentation_config['colors']['primary']; ?>; margin-bottom: 25px;">📋 Success Criteria</h3>
                            <ul style="font-size: 1.1em; line-height: 2;">
                                <li>✅ All three plants using the system within 8 weeks</li>
                                <li>✅ 95% user adoption rate within 3 months</li>
                                <li>✅ 50% reduction in document approval time</li>
                                <li>✅ Zero compliance issues in first audit</li>
                                <li>✅ Positive user feedback (>4.0/5.0 rating)</li>
                                <li>✅ System uptime >99.5%</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="cta-box">
                        <h3 style="margin-bottom: 15px;">🎯 Ready to Transform Document Management?</h3>
                        <p style="font-size: 1.2em;">Let's implement this SharePoint solution and revolutionize how we manage documents across <?php echo implode(', ', $presentation_config['plants']); ?> power plants.</p>
                    </div>
                    <?php
                    break;

                case 10:
                    // Questions & Discussion
                    ?>
                    <div class="slide-header">
                        <h1 class="slide-title">Questions & Discussion</h1>
                    </div>
                    
                    <div class="highlight-box">
                        <h2 style="color: <?php echo $presentation_config['colors']['primary']; ?>; margin-bottom: 20px;">Thank You</h2>
                        <p style="font-size: 1.4em; margin-bottom: 30px;"><?php echo $presentation_config['title']; ?> for Iraq Power Plants</p>
                    </div>
                    
                    <div class="contact-cards">
                        <div class="contact-card">
                            <h4>📧 Contact</h4>
                            <p><?php echo $presentation_config['presenter']; ?></p>
                            <p>Siemens Energy</p>
                        </div>
                        
                        <div class="contact-card">
                            <h4>🏭 Project Scope</h4>
                            <?php foreach($presentation_config['plants'] as $plant): ?>
                            <p><?php echo $plant; ?> Power Plant</p>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="contact-card">
                            <h4>⏱️ Timeline</h4>
                            <p>8-week implementation</p>
                            <p>Phased rollout approach</p>
                        </div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 50px;">
                        <h3 style="color: <?php echo $presentation_config['colors']['secondary']; ?>; margin-bottom: 20px;">Questions & Discussion</h3>
                        <p style="font-size: 1.3em; color: #666;">Ready to discuss implementation details, budget requirements, or technical specifications?</p>
                    </div>
                    <?php
                    break;

                default:
                    echo "<h1>Slide not found</h1>";
                    break;
            }
            ?>
        </div>
        
        <?php echo generateNavigation($current_slide, $total_slides); ?>
    </div>

    <script>
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowRight' || e.key === ' ') {
                const nextBtn = document.querySelector('.nav-btn.next');
                if (nextBtn) nextBtn.click();
            } else if (e.key === 'ArrowLeft') {
                const prevBtn = document.querySelector('.nav-btn.prev');
                if (prevBtn) prevBtn.click();
            }
        });

        // Auto-refresh KPI data every 5 minutes (for slide 5)
        <?php if($current_slide == 5): ?>
        setInterval(function() {
            // In a real implementation, this would fetch updated KPI data
            console.log('Refreshing KPI data...');
        }, 300000);
        <?php endif; ?>
    </script>
</body>
</html>