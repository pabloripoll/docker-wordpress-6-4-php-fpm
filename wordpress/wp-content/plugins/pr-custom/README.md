# Plugin API
version 1.0.0

Development Stage

## Navigation from Pages

Structure architecture concept
```
.
├── .Page
│   ├── .Board
│   │   ├── .Section
│   │   └── .Section
│   └── .Board
│       ├── .Section
│       └── .Section
│
└── .Page ...
```

Example built from concept
```
.
├── .Example
│   ├── .Dashboard
│   │   ├── .Section-Graph
│   │   └── .Section-Pie-Graph
│   └── .Listing
│       ├── .Section-Filter
│       └── .Section-Table
│
└── .Settings
    ├── .ApiConnect
    │   ├── .Section-Recorded
    │   └── .Section-Update
    └── .WpConnect
        ├── .Section-Recorded
        └── .Section-Update
```